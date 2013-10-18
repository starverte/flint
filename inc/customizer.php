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
}
add_action( 'customize_preview_init', 'flint_customize_preview_js' );
