<?php
/**
 * Flint Theme Customizer
 *
 * @package Flint
 * @since 1.2.1
 */

function flint_customize_register( $wp_customize ) {
  $fonts = array(
    'Open Sans'  => 'Open Sans',
    'Oswald'     => 'Oswald',
    'Roboto'     => 'Roboto',
    'Droid Sans' => 'Droid Sans',
    'Lato'       => 'Lato',
    'Strait'     => 'Strait',
  );
  
  $wp_customize->add_setting('flint_colors[link]', array(
    'default'           => '#428bca',
    'sanitize_callback' => 'sanitize_hex_color',
    'capability'        => 'edit_theme_options',
    'type'              => 'option',
    'transport'         => 'postMessage',
  ));
  
  $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'link', array(
    'label'    => __('Links', 'flint'),
    'section'  => 'colors',
    'settings' => 'flint_colors[link]',
    'priority' => '60',
  )));
  
  $wp_customize->add_setting('flint_colors[canvas]', array(
    'default'           => '#222222',
    'sanitize_callback' => 'sanitize_hex_color',
    'capability'        => 'edit_theme_options',
    'type'              => 'option',
    'transport'         => 'postMessage',
  ));
  
  $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'canvas', array(
    'label'    => __('Canvas', 'flint'),
    'section'  => 'colors',
    'settings' => 'flint_colors[canvas]',
    'priority' => '70',
  )));
  
  $wp_customize->add_setting('flint_colors[canvas-text]', array(
    'default'           => '#ffffff',
    'sanitize_callback' => 'sanitize_hex_color',
    'capability'        => 'edit_theme_options',
    'type'              => 'option',
    'transport'         => 'postMessage',
  ));
  
  $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'canvas_text', array(
    'label'    => __('Canvas Text', 'flint'),
    'section'  => 'colors',
    'settings' => 'flint_colors[canvas-text]',
    'priority' => '80',
  )));
  
  $wp_customize->add_section( 'flint_fonts' , array(
    'title'      => __( 'Fonts', 'flint' ),
    'priority'   => 30,
  ));
  
  $wp_customize->add_setting('flint_fonts[heading_font]', array(
    'default'           => 'Open Sans',
    'capability'        => 'edit_theme_options',
    'type'              => 'option',
    'transport'         => 'postMessage',
  ));
  
  $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'heading_font', array(
    'label'    => __('Headings', 'flint'),
    'section'  => 'flint_fonts',
    'settings' => 'flint_fonts[heading_font]',
    'priority' => '10',
    'type' => 'select',
    'choices' => $fonts,
  )));
  
  $wp_customize->add_setting('flint_fonts[body_font]', array(
    'default'           => 'Open Sans',
    'capability'        => 'edit_theme_options',
    'type'              => 'option',
    'transport'         => 'postMessage',
  ));
  
  $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'body_font', array(
    'label'    => __('Body', 'flint'),
    'section'  => 'flint_fonts',
    'settings' => 'flint_fonts[body_font]',
    'priority' => '20',
    'type' => 'select',
    'choices' => $fonts,
  )));
  
  $wp_customize->get_setting( 'blogname'         )->transport = 'postMessage';
  $wp_customize->get_setting( 'blogdescription'  )->transport = 'postMessage';
  $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'flint_customize_register' );

function flint_customize_preview_init() {
  wp_enqueue_script( 'flint_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), flint_theme_version(), true );
  
  wp_enqueue_style( 'open-sans' , '//fonts.googleapis.com/css?family=Open+Sans:300,600,300,700,300italic,600italic,700italic', array(), '' );
  wp_enqueue_style( 'oswald'    , '//fonts.googleapis.com/css?family=Oswald:300,400,700'                                     , array(), '' );
  wp_enqueue_style( 'roboto'    , '//fonts.googleapis.com/css?family=Roboto:300,300italic,400,400italic,700,700italic'       , array(), '' );
  wp_enqueue_style( 'droid-sans', '//fonts.googleapis.com/css?family=Droid+Sans:400,700'                                     , array(), '' );
  wp_enqueue_style( 'lato'      , '//fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic'         , array(), '' );
  wp_enqueue_style( 'strait'    , '//fonts.googleapis.com/css?family=Strait'                                                 , array(), '' );
}
add_action( 'customize_preview_init', 'flint_customize_preview_init' );
