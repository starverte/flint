<?php
/**
 * Flint Theme Customizer
 *
 * @package Flint
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function flint_customize_register( $wp_customize ) {
  $fonts = array(
    'Open Sans'  => 'Open Sans',
    'Oswald'     => 'Oswald',
    'Roboto'     => 'Roboto',
    'Droid Sans' => 'Droid Sans',
    'Lato'       => 'Lato',
  );
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
    'priority' => '60',
  )));
  
  $wp_customize->add_setting('flint_colors[canvas-text]', array(
    'default'           => '#ffffff',
    'sanitize_callback' => 'sanitize_hex_color',
    'capability'        => 'edit_theme_options',
    'type'              => 'option',
    'transport'         => 'postMessage',
  ));
  
  $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'canvas-text', array(
    'label'    => __('Canvas Text', 'flint'),
    'section'  => 'colors',
    'settings' => 'flint_colors[canvas-text]',
    'priority' => '70',
  )));
  
  $wp_customize->add_setting('flint_colors[canvas-link]', array(
    'default'           => '#999999',
    'sanitize_callback' => 'sanitize_hex_color',
    'capability'        => 'edit_theme_options',
    'type'              => 'option',
    'transport'         => 'postMessage',
  ));
  
  $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'canvas-link', array(
    'label'    => __('Canvas Link', 'flint'),
    'section'  => 'colors',
    'settings' => 'flint_colors[canvas-link]',
    'priority' => '80',
  )));
  
  $wp_customize->add_section( 'flint_fonts' , array(
    'title'      => __( 'Fonts', 'flint' ),
    'priority'   => 30,
  ));
  
  $wp_customize->add_setting('flint_fonts[heading-font]', array(
    'default'           => 'Open Sans',
    'capability'        => 'edit_theme_options',
    'type'              => 'option',
    'transport'         => 'postMessage',
  ));
  
  $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'heading-font', array(
    'label'    => __('Headings', 'flint'),
    'section'  => 'flint_fonts',
    'settings' => 'flint_fonts[heading-font]',
    'priority' => '10',
    'type' => 'select',
    'choices' => $fonts,
  )));
  
  $wp_customize->add_setting('flint_fonts[body-font]', array(
    'default'           => 'Open Sans',
    'capability'        => 'edit_theme_options',
    'type'              => 'option',
    'transport'         => 'postMessage',
  ));
  
  $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'body-font', array(
    'label'    => __('Body', 'flint'),
    'section'  => 'flint_fonts',
    'settings' => 'flint_fonts[body-font]',
    'priority' => '20',
    'type' => 'select',
    'choices' => $fonts,
  )));
  
  $wp_customize->get_setting( 'blogname'         )->transport = 'postMessage';
  $wp_customize->get_setting( 'blogdescription'  )->transport = 'postMessage';
  $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'flint_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function flint_customize_preview_js() {
  wp_enqueue_script( 'flint_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '1.1.0', true );
  wp_enqueue_style( 'open-sans', 'http://fonts.googleapis.com/css?family=Open+Sans:300,600,300,700,300italic,600italic,700italic', array(), '' );
  wp_enqueue_style( 'oswald', 'http://fonts.googleapis.com/css?family=Oswald:300,400,700', array(), '' );
  wp_enqueue_style( 'roboto', 'http://fonts.googleapis.com/css?family=Roboto:300,300italic,400,400italic,700,700italic', array(), '' );
  wp_enqueue_style( 'droid-sans', 'http://fonts.googleapis.com/css?family=Droid+Sans:400,700', array(), '' );
  wp_enqueue_style( 'lato', 'http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic', array(), '' );
}
add_action( 'customize_preview_init', 'flint_customize_preview_js' );
