<?php
/**
 * Flint Theme Customizer
 *
 * @package Flint
 * @since 1.2.1
 */

function flint_customize_register( $wp_customize ) {

  global $a_color;
  global $canvas_bg;
  global $canvas_color;

  $fonts = array(
    'Open Sans'   => 'Open Sans',
    'Oswald'      => 'Oswald',
    'Roboto'      => 'Roboto',
    'Droid Sans'  => 'Droid Sans',
    'Lato'        => 'Lato',
    'Nova Square' => 'Nova Square',
    'Strait'      => 'Strait',
  );

  $wp_customize->add_section( 'flint_general' , array(
    'title'      => __( 'Footer', 'flint' ),
    'priority'   => 25,
  ));

  $wp_customize->add_setting('flint_general[text]', array(
    'default'           => '',
    'capability'        => 'edit_theme_options',
    'type'              => 'option',
    'transport'         => 'postMessage',
  ));

  $wp_customize->add_control( new Flint_Customize_TextArea_Control($wp_customize, 'text', array(
    'label'    => __('Footer Text', 'flint'),
    'section'  => 'flint_general',
    'settings' => 'flint_general[text]',
    'priority' => '10',
    'type'     => 'textarea',
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

  $wp_customize->add_setting('flint_colors[link]', array(
    'default'           => '#'.$a_color,
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
    'default'           => '#'.$canvas_bg,
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
    'default'           => '#'.$canvas_color,
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

  $wp_customize->add_section( 'flint_layout' , array(
    'title'      => __( 'Featured Images', 'flint' ),
    'priority'   => 80,
  ));

  $wp_customize->add_setting('flint_layout[posts_image]', array(
    'default'           => 'always',
    'capability'        => 'edit_theme_options',
    'type'              => 'option',
    'transport'         => 'postMessage',
  ));

  $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'posts_image', array(
    'label'    => __('Show for Posts', 'flint'),
    'section'  => 'flint_layout',
    'settings' => 'flint_layout[posts_image]',
    'priority' => '10',
    'type' => 'select',
    'choices' => array(
      'always'    =>  'Always',
      'archives'  =>  'Archives/Search Only',
      'never'     =>  'Never',
    ),
  )));

  $wp_customize->add_setting('flint_layout[pages_image]', array(
    'default'           => 'always',
    'capability'        => 'edit_theme_options',
    'type'              => 'option',
    'transport'         => 'postMessage',
  ));

  $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'pages_image', array(
    'label'    => __('Show for Pages', 'flint'),
    'section'  => 'flint_layout',
    'settings' => 'flint_layout[pages_image]',
    'priority' => '20',
    'type' => 'select',
    'choices' => array(
      'always'    =>  'Always',
      'archives'  =>  'Archives/Search Only',
      'never'     =>  'Never',
    ),
  )));

  $wp_customize->get_setting( 'blogname'         )->transport = 'postMessage';
  $wp_customize->get_setting( 'blogdescription'  )->transport = 'postMessage';
  $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'flint_customize_register' );

function flint_customize_preview_init() {
  wp_enqueue_script( 'flint_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), flint_theme_version(), true );

  wp_enqueue_style( 'open-sans'  , '//fonts.googleapis.com/css?family=Open+Sans:300,600,300,700,300italic,600italic,700italic', array(), '' );
  wp_enqueue_style( 'oswald'     , '//fonts.googleapis.com/css?family=Oswald:300,400,700'                                     , array(), '' );
  wp_enqueue_style( 'roboto'     , '//fonts.googleapis.com/css?family=Roboto:300,300italic,400,400italic,700,700italic'       , array(), '' );
  wp_enqueue_style( 'droid-sans' , '//fonts.googleapis.com/css?family=Droid+Sans:400,700'                                     , array(), '' );
  wp_enqueue_style( 'lato'       , '//fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic'         , array(), '' );
  wp_enqueue_style( 'nova-square', '//fonts.googleapis.com/css?family=Nova+Square'                                            , array(), '' );
  wp_enqueue_style( 'strait'     , '//fonts.googleapis.com/css?family=Strait'                                                 , array(), '' );
}
add_action( 'customize_preview_init', 'flint_customize_preview_init' );

if (class_exists('WP_Customize_Control')) {
  class Flint_Customize_TextArea_Control extends WP_Customize_Control {
    public $type = 'textarea';
    public $description;

    public function render_content() {
        ?>
        <label>
          <?php if ( ! empty( $this->label ) ) : ?>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
          <?php endif;
          if ( ! empty( $this->description ) ) : ?>
            <span class="description customize-control-description"><?php echo $this->description; ?></span>
          <?php endif; ?>
          <textarea rows="5" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
        </label>
        <?php
    }
  }
}
