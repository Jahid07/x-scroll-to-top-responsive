<?php
/*
Plugin Name: X-Scroll To Top - Responsive
Plugin URI: https://wordpress.org/plugins/x-scroll-to-top-responsive/
Description: This plugin will add a scroll to top.
Author: Jahid
Author URI: https://jahid.co
Text Domain: x-scroll-to-top-responsive
Domain Path: /i18n/languages
Version: 3.1.2
*/

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// Include the Composer autoloader
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Plugin Text Domain
 */
function xscroll_domain_load_function(){
    load_plugin_textdomain('x-scroll-to-top-responsive', false, dirname(__FILE__)."/i18n/languages");
}
add_action('plugins_loaded', 'xscroll_domain_load_function');

/**
 * Currently plugin version.
 * Start at version 3.1.0 
 * Rename this for your plugin and update it as you release new versions.
 */
define('XSTR_VERSION', '3.1.1');

define('XSTR_PLUGIN_URL', plugin_dir_url(__FILE__));

// Constant of plugin directory
define('XSTR_PLUGIN_PATH', plugin_dir_path(__FILE__));

// Constant of plugin based name
define('XSTR_PLUGIN_BASENAME', plugin_basename(__FILE__));

/**
 * The code that runs during plugin activation.
 */
function activate_XSTR() {
    CoderPlus\XScrollTopResponsive\Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_XSTR() {
    CoderPlus\XScrollTopResponsive\Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_XSTR');
register_deactivation_hook(__FILE__, 'deactivate_XSTR');

use CoderPlus\XScrollTopResponsive\Core;
use CoderPlus\XScrollTopResponsive\Assets;
use CoderPlus\XScrollTopResponsive\Customizer;
use CoderPlus\XScrollTopResponsive\AdminNotice;
use CoderPlus\XScrollTopResponsive\CoreUpdate;

add_action('admin_notices', [AdminNotice::class, 'admin_notices_old_user']);

// Initialize the Core class
$core = new Core();
$core->init();

// Initialize the CoreUpdate class
CoreUpdate::init();

// Hook the migration function
register_activation_hook(__FILE__, [CoreUpdate::class, 'run_migrations']);
add_action('upgrader_process_complete', function($upgrader_object, $options) {
    if ($options['action'] == 'update' && $options['type'] == 'plugin' ) {
        if (isset($options['plugins']) && in_array(plugin_basename(__FILE__), $options['plugins'])) {
            CoreUpdate::run_migrations();
        }
    }
}, 10, 2);

$assets = new Assets();
$assets->init();

$customizer = new Customizer();
$customizer->init();

// Add custom update message
add_filter('pre_update_option_update_plugins', function($value) {
    if (isset($value->response['x-scroll-to-top-responsive/plugin-hook.php'])) {
        add_action('admin_notices', function() {
            echo '<div class="notice notice-warning is-dismissible">';
            echo '<p>' . __('A core update for the X-Scroll To Top - Responsive plugin is available. Before update please check new Screenshots and documentation. Please ensure you backup your database before updating.', 'x-scroll-to-top-responsive') . '</p>';
            echo '</div>';
        });
    }
    return $value;
});
