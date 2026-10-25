<?php

/* @link       https://jahid.co/
 * @since      3.0.0
 *
 * @package    xscroll
 * @subpackage x-scroll-to-top-responsive/inc
 */

/**
 * This class.
 *
 * This class defines the custom customizer for the plugin.
 *
 * @since      3.0.0
 * @package    xscroll
 * @subpackage x-scroll-to-top-responsive/inc
 * @author     Jahid <contact@jahid.co>
 */

namespace CoderPlus\XScrollTopResponsive;

use WP_Customize_Control;

class CustomCustomizer {
    public function __construct() {
        add_action('customize_register', [$this, 'my_customize_register']);
    }

    public function my_customize_register($wp_customize) {
        if (class_exists('WP_Customize_Control')) {
            $wp_customize->add_control(new WP_Customize_Textarea_Control($wp_customize, 'xscroll_textarea', array(
                'label' => __('Email marketing for creators!', 'x-scroll-to-top-responsive'),
                'section' => 'xscroll_general_settings',
                'settings' => 'xscroll_textarea_setting',
                'type' => 'button',
            )));
        }
    }
}

// Declare WP_Customize_Textarea_Control outside of the CustomCustomizer class
if (class_exists('WP_Customize_Control')) {
    class WP_Customize_Textarea_Control extends WP_Customize_Control {
        public $type = 'button';

        public function render_content() {
            ?>
            <p class="customize-control-text"><?php echo esc_html($this->label); ?></p>
            <a href="https://mbsy.co/convertkit/Jahid" target="_blank" class="mr_button" id="create-new-menu-submit" tabindex="0"><?php _e('Get A Free Trial!'); ?></a>
            <?php
        }
    }
}

// Initialize the CustomCustomizer class
new \CoderPlus\XScrollTopResponsive\CustomCustomizer();
