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
 * This class defines all code necessary to run admin notice for the plugin.
 *
 * @since      3.0.0
 * @package    xscroll
 * @subpackage x-scroll-to-top-responsive/inc
 * @author     Jahid <contact@jahid.co>
 */

namespace CoderPlus\XScrollTopResponsive;

class AdminNotice {

	/**
	 * This method will run upon if the user has old data from the old plugin
	 *
	 * Long Description.
	 *
	 * @since    3.0.0
	 */

	public static function admin_notices_old_user() {
		// Get old plugin data
		$color 		= @get_option( 'x_scroll_color', null);
		$size 		= @get_option( 'x_scroll_size', null);
		$background = @get_option( 'x_field_bg', null);
		$position 	= @get_option( 'x_scroll_position', null);
		$border 	= @get_option( 'x_scroll_border', null);

		if(!empty($color) || !empty($size) || !empty($background) || !empty($position) || !empty($border) ){
			echo "<div class='notice notice-error is-dismissible'><p><strong>Important Note:</strong>: Thank you for the updating X Scroll to top plugin. We move settings page from Settings->X Scroll option to new ".'<a href="' . admin_url( 'customize.php?autofocus[panel]=xscroll_customize_setting' ) . '">Settings</a>'."  with some cool feature. Please check the documetation <a href='https://wordpress.org/plugins/x-scroll-to-top-responsive/' target='_blank'>here</a></p></div>";
		}
		
	}
	
	
	
}
