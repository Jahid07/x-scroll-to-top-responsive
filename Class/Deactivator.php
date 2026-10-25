<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://jahid.co/
 * @since      3.0.0
 *
 * @package    xscroll
 * @subpackage x-scroll-to-top-responsive/inc
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      3.0.0
 * @package    xscroll
 * @subpackage x-scroll-to-top-responsive/inc
 * @author     Jahid <contact@jahid.co>
 */
namespace CoderPlus\XScrollTopResponsive;

class Deactivator {

	/**
	 * This method will run upon deactivation
	 *
	 * Long Description.
	 *
	 * @since    3.0.0
	 */
	public static function deactivate() {

		// Flush rewrite rules upon deactivation
		flush_rewrite_rules( );
	}

}
