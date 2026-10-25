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

class Core{

    public $pluginbs = XSTR_PLUGIN_BASENAME;

    public function init()
    {
        add_filter( 'plugin_action_links_' . $this->pluginbs, [__CLASS__, 'action_links'] );
        add_action('wp_footer', [$this, 'scroll_icon']);
    }
       
    /**
     * Plugin action link for setting page
     * @package xscroll
     * @param $link
     * @since    3.0.0
     * 
     */
    public static function action_links ( $links ) {
        $setting_links = array(
            '<a href="' . admin_url( 'customize.php?autofocus[panel]=xscroll_customize_setting' ) . '">Settings</a>',
        );
        return array_merge( $links, $setting_links );
    }


    /**
     * Add Icon into the Footer
     * @package xscroll
     * @since    3.0.0
     */
    public function scroll_icon(){
        $xscroll_icon_picker = self::get_xstr_option('icon_picker', 'icon-up-open');
        ?>
            <div class="scroll-to-top">
                <a href="#"><i class="<?php echo $xscroll_icon_picker;?>"></i></a>
            </div>
        <?php
    }

    /**
     * Create get_xstr_option method for get option form theme customizer.
     * 
     * @package xscroll     
     * @param optionNaeme,default 
     * @since    3.0.0
     */

    public static function get_xstr_option($optionNaeme, $default = null)
    {
        $option = get_option('xstr_option');
        $option = @$option[$optionNaeme];

        if(!empty($option)){
            $option = $option;
        }else{
            $option = $default;
        }

        return $option;
    }


}



