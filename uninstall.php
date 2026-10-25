<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * 
 *
 * @link       https://jahid.co/
 * @since      3.0.0
 * @author     Jahid
 * @package    xscroll
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

/**
 * Delete xstr_option row while delete the plugin
 */
  
 global $wpdb;
 $name = 'xstr_option';
 $table = $wpdb->prefix . 'options'; // Corrected the table name concatenation
 
 // Check if the option exists
 $option_exists = $wpdb->get_var($wpdb->prepare("SELECT option_id FROM $table WHERE option_name = %s", $name));
 
 if ($option_exists) {
	 // If the option exists and name is not empty, delete it
	 if (!empty($name)) {
		 $wpdb->delete($table, array('option_name' => $name));
	 }
 }
 
 



