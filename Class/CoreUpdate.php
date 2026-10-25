<?php

namespace CoderPlus\XScrollTopResponsive;

class CoreUpdate {

   

    public static function init() {
      
        add_action('plugins_loaded', [__CLASS__, 'run_migrations']);
        add_action('admin_notices', [__CLASS__, 'show_deletion_notice']);
        add_action('wp_ajax_delete_old_xscroll_settings', [__CLASS__, 'handle_delete_old_settings']);
        add_action('admin_enqueue_scripts', [__CLASS__, 'enqueue_scripts']);
    }

    public static function run_migrations() {
        // Only run migrations if the new Customizer settings are not already filled
        if (self::needs_migration()) {
            self::migrate_settings();
        }
    }

    private static function needs_migration() {
        // Check if the new serialized option is already set
        $new_options = get_option('xstr_option', false);
        return $new_options === false; // Migration needed if the new option does not exist
    }

    private static function sanitize_value($value) {
        return preg_replace('/[^0-9]/', '', $value);
    }

    private static function convert_position($old_position) {
        // Convert right-to-left to left-to-right
        $sanitized_value = self::sanitize_value($old_position);
        return 100 - intval($sanitized_value);
    }

    private static function migrate_settings() {
        // Retrieve old settings
        $old_color = get_option('x_scroll_color', null);
        $old_size = get_option('x_scroll_size', null);
        $old_background = get_option('x_field_bg', null);
        $old_position = get_option('x_scroll_position', null);
        $old_border = get_option('x_scroll_border', null);

        // Define new settings with default values
        $new_settings = array(
            'size' => 30,
            'border_radius' => 10,
            'icon_color' => '#ffffff',
            'icon_bg_color' => '#dd3333',
            'icon_hover_color' => '#ffffff',
            'icon_hover_bg_color' => '#000000',
            'icon_position' => 98,
            'icon_position_tablet_mobile' => 95,
            'icon_show_tablet_mobile' => 1, // Default show
        );

        // Sanitize and map old settings to new settings
        if ($old_size !== null) {
            $new_settings['size'] = self::sanitize_value($old_size) * 2;
            $new_settings['icon_size'] = $new_settings['size'];
        }

        if ($old_color !== null) {
            $new_settings['icon_color'] = $old_color;
        }

        if ($old_background !== null) {
            $new_settings['icon_bg_color'] = $old_background;
        }

        if ($old_position !== null) {
            $new_settings['icon_position'] = self::convert_position($old_position);
        }

        if ($old_border !== null) {
            $new_settings['border_radius'] = self::sanitize_value($old_border);
        }
        
        $new_settings['icon_picker'] = 'icon-up-open';

        // Save all new settings in a single serialized option
        update_option('xstr_option', $new_settings);
    }

    public static function show_deletion_notice() {
        // Check if old settings exist
        $old_color = get_option('x_scroll_color', null);
        $old_size = get_option('x_scroll_size', null);
        $old_background = get_option('x_field_bg', null);
        $old_position = get_option('x_scroll_position', null);
        $old_border = get_option('x_scroll_border', null);

        if ($old_color !== null || $old_size !== null || $old_background !== null || $old_position !== null || $old_border !== null) {
            echo '<div class="notice notice-warning is-dismissible">';
            echo '<p>' . __('We have detected old settings from the previous version of the X-Scroll To Top plugin. Please <a href="#" id="delete-old-settings">click here</a> to delete these old settings.', 'x-scroll-to-top-responsive') . '</p>';
            echo '</div>';
        }
    }

    public static function handle_delete_old_settings() {
        // Verify nonce
        check_ajax_referer('delete_old_settings_nonce', 'nonce');

        // Delete old settings
        delete_option('x_scroll_color');
        delete_option('x_scroll_size');
        delete_option('x_field_bg');
        delete_option('x_scroll_position');
        delete_option('x_scroll_border');

        wp_send_json_success([
            'message' => 'Old settings have been deleted.',
            'redirect_url' => admin_url('customize.php?autofocus[panel]=xscroll_customize_setting')
        ]);
    }

    public static function enqueue_scripts() {
        wp_enqueue_script('xscroll-admin', XSTR_PLUGIN_URL . 'assets/js/xscroll-admin.js', ['jquery'], XSTR_VERSION, true);
        wp_localize_script('xscroll-admin', 'xscrollAdmin', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('delete_old_settings_nonce'),
        ]);
    }
}
