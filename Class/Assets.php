<?php
/*
@link       https://jahid.co/
 * @since      3.0.0
 *
 * @package    xscroll
 * @subpackage x-scroll-to-top-responsive/inc
 */

/**
 * This class.
 *
 * This class defines all code necessary to run plugins assets files.
 *
 * @since      3.0.0
 * @package    xscroll
 * @subpackage x-scroll-to-top-responsive/inc
 * @author     Jahid <contact@jahid.co>
 * */

namespace CoderPlus\XScrollTopResponsive;

class Assets {

	// Public poperty for plugin url & plugin version
	public $plugindir = XSTR_PLUGIN_URL;
	public $version   = XSTR_VERSION;

	/**
	 * Register action and filter
	 *
	 * @package xscroll
	 * @since    3.0.0
	 */
	public function init() {
		add_action( 'wp_enqueue_scripts', array( $this, 'assets' ) );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'customize_enqueue' ) );
		add_action( 'customize_preview_init', array( $this, 'customizer_live_preview' ) );
	}

	/**
	 * Plugin frontend assets
	 *
	 * @package xscroll
	 * @since    3.0.0
	 */
	function assets() {
		wp_enqueue_style( 'xscroll-plugin-css', XSTR_PLUGIN_URL . 'assets/css/custom.css', null, $this->version );
		wp_enqueue_style( 'fontello', XSTR_PLUGIN_URL . 'assets/css/fontello.css', null, $this->version );
		wp_enqueue_script( 'x-jquery-active', XSTR_PLUGIN_URL . 'assets/js/active.js', array( 'jquery' ), $this->version, true );

		$xscroll_size          = Core::get_xstr_option( 'size', 30 );
		$xscroll_border_radius = Core::get_xstr_option( 'border_radius', 10 );
		$xscroll_icon_size     = $xscroll_size / 2;
		$xscroll_icon_color    = Colors::sanitize( Core::get_xstr_option( 'icon_color', '#ffffff' ) );
		if ( null === $xscroll_icon_color ) {
			$xscroll_icon_color = '#ffffff';
		}
		$xscroll_icon_bg_color = Colors::sanitize( Core::get_xstr_option( 'icon_bg_color', '#dd3333' ) );
		if ( null === $xscroll_icon_bg_color ) {
			$xscroll_icon_bg_color = '#dd3333';
		}
		$xscroll_icon_hover_color = Colors::sanitize( Core::get_xstr_option( 'icon_hover_color', '#ffffff' ) );
		if ( null === $xscroll_icon_hover_color ) {
			$xscroll_icon_hover_color = '#ffffff';
		}
		$xscroll_icon_hover_bg_color = Colors::sanitize( Core::get_xstr_option( 'icon_hover_bg_color', '#000000' ) );
		if ( null === $xscroll_icon_hover_bg_color ) {
			$xscroll_icon_hover_bg_color = '#000000';
		}
		$xscroll_icon_position                 = Core::get_xstr_option( 'icon_position', 98 );
		$xscroll_icon_position_y               = Core::get_xstr_option( 'icon_position_y', 4 );
		$xscroll_size_mobile                   = Core::get_xstr_option( 'size_mobile', 30 );
		$xscroll_icon_size_mobile              = $xscroll_size_mobile / 2;
		$xscroll_icon_position_tablet_mobile   = Core::get_xstr_option( 'icon_position_tablet_mobile', 96 );
		$xscroll_icon_position_tablet_mobile_y = Core::get_xstr_option( 'icon_position_tablet_mobile_y', 4 );
		$xscroll_icon_show_tablet_mobile       = Core::get_xstr_option( 'icon_show_tablet_mobile', 0 );
		$show_hide                             = $xscroll_icon_show_tablet_mobile == 1 ? 'block' : 'none';

		error_log( $xscroll_icon_show_tablet_mobile );

		$custom_css = "
            .scroll-to-top a{
                width: {$xscroll_size}px;
                height: {$xscroll_size}px;
                border-radius: {$xscroll_border_radius}%;
                font-size: {$xscroll_icon_size}px;
                color: {$xscroll_icon_color};
                background: {$xscroll_icon_bg_color};
                margin-left: -{$xscroll_icon_size}px;
            }
    
            .scroll-to-top:hover a {
                background: {$xscroll_icon_hover_bg_color};
                color: {$xscroll_icon_hover_color};
            }
    
            .scroll-to-top {
                left: {$xscroll_icon_position}%;
            }

            .scroll-to-top {
                bottom: {$xscroll_icon_position_y}%;
            }
    
            @media (max-width: 991px) {
                
                .scroll-to-top {
                    left: {$xscroll_icon_position_tablet_mobile}%;
                }
            }    
            
            @media (max-width: 767px) {
                .scroll-to-top a{

                    width: {$xscroll_size_mobile}px;
                    height: {$xscroll_size_mobile}px;
                    font-size: {$xscroll_icon_size_mobile}px;
                    margin-left: -{$xscroll_icon_size_mobile}px;
                }
                .scroll-to-top {
                    left: {$xscroll_icon_position_tablet_mobile}%;
                    bottom: {$xscroll_icon_position_tablet_mobile_y}%;
                    display: {$show_hide} !important;

                }
                    
            }	
        ";

		wp_add_inline_style( 'xscroll-plugin-css', $custom_css );
	}

	/**
	 * Rcustomizeview live preview assets
	 *
	 * @package xscroll
	 * @since    3.0.0
	 */
	function customizer_live_preview() {
		wp_enqueue_script( 'xscroll-customizer', XSTR_PLUGIN_URL . 'assets/js/xscroll-customizer-live-preview.js', array( 'jquery', 'customize-preview' ), $this->version, true );
	}


	/**
	 * Customize Enqueue assets
	 *
	 * @package xscroll
	 * @since    3.0.0
	 */
	function customize_enqueue() {
		wp_enqueue_style( 'fontello', XSTR_PLUGIN_URL . 'assets/css/fontello.css', null, $this->version );
		if ( version_compare( get_bloginfo( 'version' ), '5.9', '>=' ) ) {
			wp_enqueue_style( 'wp-components' );
			wp_enqueue_script( 'xscroll-customizer-colors', XSTR_PLUGIN_URL . 'assets/js/customizer-colors.js', array( 'customize-controls', 'wp-components', 'wp-element' ), $this->version . '.' . filemtime( XSTR_PLUGIN_PATH . 'assets/js/customizer-colors.js' ), true );
		}
		wp_enqueue_style( 'previewcss', XSTR_PLUGIN_URL . 'assets/css/previewcss.css', null, $this->version . '.' . filemtime( XSTR_PLUGIN_PATH . 'assets/css/previewcss.css' ) );

		wp_enqueue_script( 'custom-customize', XSTR_PLUGIN_URL . 'assets/js/custom-customize.js', array( 'jquery', 'customize-controls' ), $this->version, true );
	}
}
