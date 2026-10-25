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
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      3.0.0
 * @package    xscroll
 * @subpackage x-scroll-to-top-responsive/inc
 * @author     Jahid <contact@jahid.co>
 * */
namespace CoderPlus\XScrollTopResponsive;
use CoderPlus\XScrollTopResponsive\CustomCustomizer;

class Customizer{

   
public function init()
{
    add_action( 'customize_register', [$this, 'customize_register'] );
}    

/**
 * Customizer Register
 * @package xscroll
 * @param $wp_customize
 * @since    3.0.0
 * 
 */
public function customize_register( $wp_customize ) {
	/**
	 * Main panel setting
	 */
	$wp_customize->add_panel( 'xscroll_customize_setting', array(
		'title' => __( 'X Scroll Responsive','x-scroll-to-top-responsive' ),
	));

	// ================ General Setting  ====================
	$wp_customize->add_section('xscroll_general_settings', array(
		'title' => __('General Settings','x-scroll-to-top-responsive'),
		'panel' => 'xscroll_customize_setting',
    ));

    
    // ================ Icon Picker  ====================
	$wp_customize->add_setting('xstr_option[icon_picker]', array(
		'type'	=> 'option',
		'default' => 'icon-up-open',
		'transport' => 'postMessage',
	));

	$wp_customize->add_control( 'xstr_option[icon_picker]', array(
        'label' => __('Icon Picker','x-scroll-to-top-responsive'),
		'section' => 'xscroll_general_settings',
		'setting' => 'xstr_option[icon_picker]',
		'sanitize_callback' => 'wpforge_sanitize_cs_selection',
		'type' => 'radio',
		'choices' => array(			
			"icon-up-big" => "&#xe800;",
			"icon-up-dir" => "&#xe801;",
			"icon-up-open" => "&#xe802;",
			"icon-up-open-1" => "&#xe803;",
			"icon-up-open-big" => "&#xe804;",
			"icon-up-1" => "&#xe805;",
			"icon-up-bold" => "&#xe806;",
			"icon-up-thin" => "&#xe807;",
			"icon-up-outline" => "&#xe808;",
			"icon-up-2" => "&#xe809;",
			"icon-up-small" => "&#xe80a;",
			"icon-up-3" => "&#xe80b;",
			"icon-up-4" => "&#xe80c;",
			"icon-up-hand" => "&#xe80d;",
			"icon-up" => "&#xf176;",
		)
	));

    // ================ Width  ====================
	$wp_customize->add_setting('xstr_option[size]', array(
		'type'	=> 'option',
		'default' => 30,
		'transport' => 'postMessage',
	));
	$wp_customize->add_control('xstr_option[size]', array(
        'label' => __('Icon Size','x-scroll-to-top-responsive'),
        'type' => 'range',
		'section' => 'xscroll_general_settings',
		'setting' => 'xstr_option[size]',
		'input_attrs' => array(
            'min' => 20,
            'max' => 100,
            'step' => 1,
        ),
	));


    // ================ Border Radius  ====================
	$wp_customize->add_setting('xstr_option[border_radius]', array(
		'type' => 'option',
		'default' => 5,
		'transport' => 'postMessage'
	));
	$wp_customize->add_control('xstr_option[border_radius]', array(
        'label' => __('Border Radius','x-scroll-to-top-responsive'),
        'type' => 'range',
		'section' => 'xscroll_general_settings',
		'setting' => 'xstr_option[border_radius]',
		'input_attrs' => array(
            'min' => 0,
            'max' => 50,
            'step' => 1,
        ),
    ));


    // ================ Icon Color  ====================
	$wp_customize->add_setting('xstr_option[icon_color]', array(
		'type' => 'option',
		'default' => __('#ffffff', 'x-scroll-to-top-responsive'),
		'transport' => 'postMessage'
	));

	$wp_customize->add_control(new \WP_Customize_Color_Control($wp_customize,'xstr_option[icon_color]', array(
        'label' => __('Icon color','x-scroll-to-top-responsive'),
		'section' => 'xscroll_general_settings',
		'setting' => 'xstr_option[icon_color]',
    )));

    // ================ Background Color  ====================
	$wp_customize->add_setting('xstr_option[icon_bg_color]', array(
		'type'	=> 'option',
		'default' => __('#dd3333', 'x-scroll-to-top-responsive'),
		'transport' => 'postMessage'
	));

	$wp_customize->add_control(new \WP_Customize_Color_Control($wp_customize,'xstr_option[icon_bg_color]', array(
        'label' => __('Background color','x-scroll-to-top-responsive'),
		'section' => 'xscroll_general_settings',
		'setting' => 'xstr_option[icon_bg_color]',
    )));


    // ================ Hover Icon Color  ====================
	$wp_customize->add_setting('xstr_option[icon_hover_color]', array(
		'type'	=> 'option',
		'default' => __('#000000', 'x-scroll-to-top-responsive'),
		'transport' => 'refresh'
	));

	$wp_customize->add_control(new \WP_Customize_Color_Control($wp_customize,'xstr_option[icon_hover_color]', array(
        'label' => __('Hover Icon color','x-scroll-to-top-responsive'),
		'section' => 'xscroll_general_settings',
		'setting' => 'xstr_option[icon_hover_color]',
    )));

    // ================ Hover Background Color  ====================
	$wp_customize->add_setting('xstr_option[icon_hover_bg_color]', array(
		'type'	=> 'option',
		'default' => __('#ffffff', 'x-scroll-to-top-responsive'),
		'transport' => 'refresh'
	));

	$wp_customize->add_control(new \WP_Customize_Color_Control($wp_customize,'xstr_option[icon_hover_bg_color]', array(
        'label' => __('Hover Background color','x-scroll-to-top-responsive'),
		'section' => 'xscroll_general_settings',
		'setting' => 'xstr_option[icon_hover_bg_color]',
    )));


    // ================ Icon Position  ====================
	$wp_customize->add_setting('xstr_option[icon_position]', array(
		'type'	=> 'option',
		'default' => __('50', 'x-scroll-to-top-responsive'),
		'transport' => 'postMessage'
	));

	
	$wp_customize->add_control('xstr_option[icon_position]', array(
        'label' => __('Scroll Up Position','x-scroll-to-top-responsive'),
        'type' => 'range',
		'section' => 'xscroll_general_settings',
        'setting' => 'xstr_option[icon_position]',
        'input_attrs' => array(
            'min' => 1,
            'max' => 99,
            'step' => 1,
        ),
	));

	$wp_customize->add_setting('xstr_option[icon_position_y]', array(
		'type'	=> 'option',
		'default' => __('4', 'x-scroll-to-top-responsive'),
		'transport' => 'postMessage'
	));

	$wp_customize->add_control('xstr_option[icon_position_y]', array(
        'label' => __('Scroll Up Y Position','x-scroll-to-top-responsive'),
        'type' => 'range',
		'section' => 'xscroll_general_settings',
        'setting' => 'xstr_option[icon_position]',
        'input_attrs' => array(
            'min' => 1,
            'max' => 99,
            'step' => 1,
        ),
	));
	

	// Marketing Customization
	
	$wp_customize->add_setting('xstr_option[marketing_text]', array(
		'type'	=> 'option',		
		'transport' => 'postMessage'
	));

	
	// $wp_customize->add_control(new WP_Customize_Textarea_Control( $wp_customize, 'xstr_option[marketing_text]', array(
    //     'label' => __('Email marketing for creators!','x-scroll-to-top-responsive'),
    //     'type' => 'button',
	// 	'section' => 'xscroll_general_settings',
    //     'setting' => 'xstr_option[marketing_text]',        
	// )));


	
	
	// ================ Tablet Setting  ====================
	$wp_customize->add_section('xscroll_responsive_settings', array(
		'title' => __('Responsive Settings','x-scroll-to-top-responsive'),
		'panel' => 'xscroll_customize_setting',
	));

	 // ================ Mobile cion size  ====================
	 $wp_customize->add_setting('xstr_option[size_mobile]', array(
		'type'	=> 'option',
		'default' => 30,
		'transport' => 'postMessage',
	));
	$wp_customize->add_control('xstr_option[size_mobile]', array(
        'label' => __('Icon Size','x-scroll-to-top-responsive'),
        'type' => 'range',
		'section' => 'xscroll_responsive_settings',
		'setting' => 'xstr_option[size]',
		'input_attrs' => array(
            'min' => 20,
            'max' => 100,
            'step' => 1,
        ),
	));
	
	// ================ Icon Position  In Tablet ====================
	$wp_customize->add_setting('xstr_option[icon_position_tablet_mobile]', array(
		'type'	=> 'option',
		'default' => __('96', 'x-scroll-to-top-responsive'),
		'transport' => 'postMessage'
	));

	$wp_customize->add_control('xstr_option[icon_position_tablet_mobile]', array(
        'label' => __('Position In Tablet and Mobile ','x-scroll-to-top-responsive'),
        'type' => 'range',
		'section' => 'xscroll_responsive_settings',
        'setting' => 'xstr_option[icon_position_tablet_mobile]',
        'input_attrs' => array(
            'min' => 1,
            'max' => 99,
            'step' => 1,
        ),
	));

	$wp_customize->add_setting('xstr_option[icon_position_tablet_mobile_y]', array(
		'type'	=> 'option',
		'default' => __('4', 'x-scroll-to-top-responsive'),
		'transport' => 'postMessage'
	));

	$wp_customize->add_control('xstr_option[icon_position_tablet_mobile_y]', array(
        'label' => __('Position In Tablet and Mobile Y','x-scroll-to-top-responsive'),
        'type' => 'range',
		'section' => 'xscroll_responsive_settings',
        'setting' => 'xstr_option[icon_position_tablet_mobile_y]',
        'input_attrs' => array(
            'min' => 1,
            'max' => 99,
            'step' => 1,
        ),
	));
	
	// ================ Show Hide Icon  Mobile and Tablet ====================
	$wp_customize->add_setting('xstr_option[icon_show_tablet_mobile]', array(
		'type'	=> 'option',
		'default' => 1,
		'transport' => 'refresh'
	));

	$wp_customize->add_control('xstr_option[icon_show_tablet_mobile]', array(
        'label' => __('Show/Hide Tablet and Mobile ','x-scroll-to-top-responsive'),
        'type' => 'checkbox',
		'section' => 'xscroll_responsive_settings',
        'setting' => 'xstr_option[icon_show_tablet_mobile]'
	));


   }

   
 }