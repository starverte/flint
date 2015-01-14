<?php
/**
 * Flint Theme Customizer
 *
 * @package Flint
 * @since 1.2.1
 */

function flint_customize_register( $wp_customize ) {

  $options = flint_get_options();

  $fonts = array(
    'Open Sans'         => 'Open Sans',
    'Oswald'            => 'Oswald',
    'Roboto'            => 'Roboto',
    'Droid Sans'        => 'Droid Sans',
    'Lato'              => 'Lato',
    'Nova Square'       => 'Nova Square',
    'Strait'            => 'Strait',
    'Yanone Kaffeesatz' => 'Yanone Kaffeesatz',
  );

  $wp_customize->remove_section( 'title_tagline' );

  /**
   * Site Information panel
   */
  $wp_customize->add_panel( 'flint_site_info' , array(
    'title'    => __( 'Site Information', 'flint' ),
    'priority' => 20,
  ));

    /**
     * Title/Tagline section
     */
    $wp_customize->add_section( 'title_tagline', array(
      'title'    => __( 'Site Title & Tagline', 'flint' ),
      'priority' => 20,
      'panel'    => 'flint_site_info',
    ));

    /**
     * Organization Information section
     */
    $wp_customize->add_section( 'flint_organization', array(
      'title'    => __( 'Organization Information', 'flint' ),
      'priority' => 40,
      'panel'    => 'flint_site_info',
    ));

      /**
       * Company Name setting
       */
      $wp_customize->add_setting('flint_options[org]', array(
        'default'    => '',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'transport'  => 'postMessage',
      ));
      $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'org', array(
        'label'    => __('Organization', 'flint'),
        'section'  => 'flint_organization',
        'settings' => 'flint_options[org]',
        'priority' => 41,
        'type'     => 'text',
      )));

      /**
       * Street Address setting
       */
      $wp_customize->add_setting('flint_options[org_address]', array(
        'default'    => '',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'transport'  => 'postMessage',
      ));
      $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'org_address', array(
        'label'    => __('Street Address', 'flint'),
        'section'  => 'flint_organization',
        'settings' => 'flint_options[org_address]',
        'priority' => 42,
        'type'     => 'text',
      )));

      /**
       * City, State setting
       */
      $wp_customize->add_setting('flint_options[org_locality]', array(
        'default'    => '',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'transport'  => 'postMessage',
      ));
      $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'org_locality', array(
        'label'    => __('City, State', 'flint'),
        'section'  => 'flint_organization',
        'settings' => 'flint_options[org_locality]',
        'priority' => 43,
        'type'     => 'text',
      )));

      /**
       * Postal Code setting
       */
      $wp_customize->add_setting('flint_options[org_postal_code]', array(
        'default'    => '',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'transport'  => 'postMessage',
      ));
      $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'org_postal_code', array(
        'label'    => __('Zip Code', 'flint'),
        'section'  => 'flint_organization',
        'settings' => 'flint_options[org_postal_code]',
        'priority' => 44,
        'type'     => 'text',
      )));

      /**
       * Phone setting
       */
      $wp_customize->add_setting('flint_options[org_tel]', array(
        'default'    => '',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'transport'  => 'postMessage',
      ));
      $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'org_tel', array(
        'label'    => __('Phone Number', 'flint'),
        'section'  => 'flint_organization',
        'settings' => 'flint_options[org_tel]',
        'priority' => 45,
        'type'     => 'tel',
      )));

      /**
       * Fax Number setting
       */
      $wp_customize->add_setting('flint_options[org_fax]', array(
        'default'    => '',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'transport'  => 'postMessage',
      ));
      $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'org_fax', array(
        'label'    => __('Fax Number', 'flint'),
        'section'  => 'flint_organization',
        'settings' => 'flint_options[org_fax]',
        'priority' => 46,
        'type'     => 'text',
      )));

      /**
       * Email Address setting
       */
      $wp_customize->add_setting('flint_options[org_email]', array(
        'default'    => '',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'transport'  => 'postMessage',
      ));
      $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'org_email', array(
        'label'    => __('Email Address', 'flint'),
        'section'  => 'flint_organization',
        'settings' => 'flint_options[org_email]',
        'priority' => 47,
        'type'     => 'email',
      )));

    /**
     * Custom Footer section
     */
    $wp_customize->add_section( 'flint_footer' , array(
      'title'       => __( 'Custom Footer', 'flint' ),
      'description' => 'Customize the footer using template tags. <a href="http://sparks.starverte.com/flint/customize/#custom_footer" target="_blank">Learn more</a>',
      'priority'    => 60,
      'panel'       => 'flint_site_info',
    ));

      /**
       * Footer Text setting
       */
      $wp_customize->add_setting('flint_options[footer_content]', array(
        'default'    => '',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'transport'  => 'postMessage',
      ));
      $wp_customize->add_control( new Flint_Customize_TextArea_Control($wp_customize, 'footer_content', array(
        'label'    => __('Footer Text', 'flint'),
        'section'  => 'flint_footer',
        'settings' => 'flint_options[footer_content]',
        'priority' => 61,
        'type'     => 'textarea',
      )));
  /**
   * Fonts section
   */
  $wp_customize->add_section( 'flint_fonts' , array(
    'title'    => __( 'Fonts', 'flint' ),
    'priority' => 30,
  ));

    /**
     * Headings font setting
     */
    $wp_customize->add_setting('flint_fonts[heading_font]', array(
      'default'    => 'Open Sans',
      'capability' => 'edit_theme_options',
      'type'       => 'option',
      'transport'  => 'postMessage',
    ));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'heading_font', array(
      'label'    => __('Headings', 'flint'),
      'section'  => 'flint_fonts',
      'settings' => 'flint_fonts[heading_font]',
      'priority' => 31,
      'type'     => 'select',
      'choices'  => $fonts,
    )));

    /**
     * Body font setting
     */
    $wp_customize->add_setting('flint_fonts[body_font]', array(
      'default'    => 'Open Sans',
      'capability' => 'edit_theme_options',
      'type'       => 'option',
      'transport'  => 'postMessage',
    ));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'body_font', array(
      'label'    => __('Body', 'flint'),
      'section'  => 'flint_fonts',
      'settings' => 'flint_fonts[body_font]',
      'priority' => 32,
      'type'     => 'select',
      'choices'  => $fonts,
    )));

  /**
   * Colors section
   */

    /**
     * Link color setting
     */
    $wp_customize->add_setting('flint_options[link_color]', array(
      'default'           => $options['link_color'],
      'sanitize_callback' => 'sanitize_hex_color',
      'capability'        => 'edit_theme_options',
      'type'              => 'option',
      'transport'         => 'postMessage',
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'link_color', array(
      'label'    => __('Links', 'flint'),
      'section'  => 'colors',
      'settings' => 'flint_options[link_color]',
      'priority' => 60,
    )));

    /**
     * Fill background color setting
     */
    $wp_customize->add_setting('flint_options[fill]', array(
      'default'           => $options['fill'],
      'sanitize_callback' => 'sanitize_hex_color',
      'capability'        => 'edit_theme_options',
      'type'              => 'option',
      'transport'         => 'postMessage',
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'fill', array(
      'label'    => __('Fill', 'flint'),
      'section'  => 'colors',
      'settings' => 'flint_options[fill]',
      'priority' => 70,
    )));

    /**
     * Fill text color setting
     */
    $wp_customize->add_setting('flint_options[fill_color]', array(
      'default'           => $options['fill_color'],
      'sanitize_callback' => 'sanitize_hex_color',
      'capability'        => 'edit_theme_options',
      'type'              => 'option',
      'transport'         => 'postMessage',
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'fill_color', array(
      'label'    => __('Fill Text', 'flint'),
      'section'  => 'colors',
      'settings' => 'flint_options[fill_color]',
      'priority' => 80,
    )));

  /**
   * Layout panel
   */
  $wp_customize->add_panel( 'flint_panel_layout' , array(
    'title'    => __( 'Layout', 'flint' ),
    'priority' => 60,
  ));

    /**
     * Default post template section
     */
    $wp_customize->add_section( 'flint_layout_posts' , array(
      'title'       => __( 'Posts', 'flint' ),
      'priority'    => 10,
      'panel'       => 'flint_panel_layout',
    ));

      /**
       * Default Content Width setting
       */
      $wp_customize->add_setting('flint_templates[default_post_width]', array(
        'default'    => 'full',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'transport'  => 'postMessage',
      ));
      $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'default_post_width', array(
        'label'    => __('Content Width', 'flint'),
        'section'  => 'flint_layout_posts',
        'settings' => 'flint_templates[default_post_width]',
        'priority' => 11,
        'type'     => 'select',
        'choices'  => array(
          'slim'   => 'Slim',
          'narrow' => 'Narrow',
          'full'   => 'Full',
          'wide'   => 'Wide',
        ),
      )));

      /**
       * Featured Images on Posts setting
       */
      $wp_customize->add_setting('flint_layout[posts_image]', array(
        'default'    => 'always',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'transport'  => 'postMessage',
      ));
      $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'posts_image', array(
        'label'    => __('Featured Images', 'flint'),
        'section'  => 'flint_layout_posts',
        'settings' => 'flint_layout[posts_image]',
        'priority' => 12,
        'type'     => 'select',
        'choices'  => array(
          'always'   => 'Always show',
          'archives' => 'Archives/Search Only',
          'never'    => 'Hide',
        ),
      )));

    /**
     * Default page template section
     */
    $wp_customize->add_section( 'flint_layout_pages' , array(
      'title'       => __( 'Pages', 'flint' ),
      'priority'    => 20,
      'panel'       => 'flint_panel_layout',
    ));

      /**
       * Default Content Width setting
       */
      $wp_customize->add_setting('flint_templates[default_width]', array(
        'default'    => 'full',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'transport'  => 'postMessage',
      ));
      $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'default_width', array(
        'label'    => __('Content Width', 'flint'),
        'section'  => 'flint_layout_pages',
        'settings' => 'flint_templates[default_width]',
        'priority' => 21,
        'type'     => 'select',
        'choices'  => array(
          'slim'   => 'Slim',
          'narrow' => 'Narrow',
          'full'   => 'Full',
          'wide'   => 'Wide',
        ),
      )));

      /**
       * Featured Images on Pages setting
       */
      $wp_customize->add_setting('flint_layout[pages_image]', array(
        'default'    => 'always',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'transport'  => 'postMessage',
      ));
      $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'pages_image', array(
        'label'    => __('Featured Images', 'flint'),
        'section'  => 'flint_layout_pages',
        'settings' => 'flint_layout[pages_image]',
        'priority' => 23,
        'type'     => 'select',
        'choices'  => array(
          'always'   => 'Always show',
          'archives' => 'Archives/Search Only',
          'never'    => 'Hide',
        ),
      )));

    /**
     * Clear template section
     */
    $wp_customize->add_section( 'flint_templates_clear' , array(
      'title'       => __( 'Clear Page Template', 'flint' ),
      'description' => __( 'Clear is a page template that allows you to focus on just your content, free from distractions.', 'flint' ),
      'priority'    => 30,
      'panel'       => 'flint_panel_layout',
    ));

      /**
       * Clear Content Width setting
       */
      $wp_customize->add_setting('flint_templates[clear_width]', array(
        'default'    => 'full',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'transport'  => 'postMessage',
      ));
      $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'clear_width', array(
        'label'    => __('Content Width', 'flint'),
        'section'  => 'flint_templates_clear',
        'settings' => 'flint_templates[clear_width]',
        'priority' => 31,
        'type'     => 'select',
        'choices'  => array(
          'slim'   => 'Slim',
          'narrow' => 'Narrow',
          'full'   => 'Full',
          'wide'   => 'Wide',
        ),
      )));

      /**
       * Clear Navigation setting
       */
      $wp_customize->add_setting('flint_templates[clear_nav]', array(
        'default'    => 'breadcrumbs',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'transport'  => 'postMessage',
      ));
      $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'clear_nav', array(
        'label'    => __('Navigation', 'flint'),
        'section'  => 'flint_templates_clear',
        'settings' => 'flint_templates[clear_nav]',
        'priority' => 32,
        'type'     => 'select',
        'choices'  => array(
          'breadcrumbs' => 'Breadcrumbs',
          'navbar'      => 'Navigation Bar',
        ),
      )));

    /**
     * Minimal template section
     */
    $wp_customize->add_section( 'flint_templates_minimal' , array(
      'title'       => __( 'Minimal Page Template', 'flint' ),
      'description' => __( 'Minimal provides an additional page template with the focus on the content and an optional widget area.', 'flint' ),
      'priority'    => 40,
      'panel'       => 'flint_panel_layout',
    ));

      /**
       * Minimal Content Width setting
       */
      $wp_customize->add_setting('flint_templates[minimal_width]', array(
        'default'    => 'full',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'transport'  => 'postMessage',
      ));
      $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'minimal_width', array(
        'label'    => __('Content Width', 'flint'),
        'section'  => 'flint_templates_minimal',
        'settings' => 'flint_templates[minimal_width]',
        'priority' => 41,
        'type'     => 'select',
        'choices'  => array(
          'slim'   => 'Slim',
          'narrow' => 'Narrow',
          'full'   => 'Full',
          'wide'   => 'Wide',
        ),
      )));

      /**
       * Minimal Navigation setting
       */
      $wp_customize->add_setting('flint_templates[minimal_nav]', array(
        'default'    => 'navbar',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'transport'  => 'postMessage',
      ));
      $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'minimal_nav', array(
        'label'    => __('Navigation', 'flint'),
        'section'  => 'flint_templates_minimal',
        'settings' => 'flint_templates[minimal_nav]',
        'priority' => 42,
        'type'     => 'select',
        'choices'  => array(
          'breadcrumbs' => 'Breadcrumbs',
          'navbar'      => 'Navigation Bar',
        ),
      )));

      /**
       * Minimal Widget Area setting
       */
      $wp_customize->add_setting('flint_templates[minimal_widget_area]', array(
        'default'    => 'none',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'transport'  => 'postMessage',
      ));
      $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'minimal_widget_area', array(
        'label'    => __('Widget Area', 'flint'),
        'section'  => 'flint_templates_minimal',
        'settings' => 'flint_templates[minimal_widget_area]',
        'priority' => 43,
        'type'     => 'select',
        'choices'  => array(
          'none'   => 'None',
          'header' => 'Header',
          'left'   => 'Left',
          'right'  => 'Right',
          'footer' => 'Footer',
        ),
      )));

  /**
   * Header Image section
   */

  /**
   * Background Image section
   */

  /**
   * Navigation section
   */

  /**
   * Widgets panel
   */

    /**
     * Widget Columns section
     */
    $wp_customize->add_section( 'flint_wa' , array(
      'title'       => __( 'Columns', 'flint' ),
      'description' => 'For screens larger than 768px wide, the header and footer areas can be divided into 3 columns.',
      'priority'    => 180,
      'panel'       => 'widgets',
    ));

      /**
       * Header Columns setting
       */
      $wp_customize->add_setting('flint_wa[header]', array(
        'default'    => '1',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'transport'  => 'postMessage',
      ));
      $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'header', array(
        'label'    => __('Header', 'flint'),
        'section'  => 'flint_wa',
        'settings' => 'flint_wa[header]',
        'priority' => 11,
        'type'     => 'select',
        'choices'  => array(
          '1' => 'Full-width',
          '3' => '3 columns',
        ),
      )));

      /**
       * Footer Columns setting
       */
      $wp_customize->add_setting('flint_wa[footer]', array(
        'default'    => '1',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'transport'  => 'postMessage',
      ));
      $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'footer', array(
        'label'    => __('Footer', 'flint'),
        'section'  => 'flint_wa',
        'settings' => 'flint_wa[footer]',
        'priority' => 12,
        'type'     => 'select',
        'choices'  => array(
          '1' => 'Full-width',
          '3' => '3 columns',
        ),
      )));

  $wp_customize->get_setting( 'blogname'         )->transport = 'postMessage';
  $wp_customize->get_setting( 'blogdescription'  )->transport = 'postMessage';
  $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'flint_customize_register' );

function flint_customize_preview_init() {
  wp_enqueue_script( 'flint_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), flint_theme_version(), true );

  wp_enqueue_style( 'open-sans'        , '//fonts.googleapis.com/css?family=Open+Sans:300,600,300,700,300italic,600italic,700italic', array(), '' );
  wp_enqueue_style( 'oswald'           , '//fonts.googleapis.com/css?family=Oswald:300,400,700'                                     , array(), '' );
  wp_enqueue_style( 'roboto'           , '//fonts.googleapis.com/css?family=Roboto:300,300italic,400,400italic,700,700italic'       , array(), '' );
  wp_enqueue_style( 'droid-sans'       , '//fonts.googleapis.com/css?family=Droid+Sans:400,700'                                     , array(), '' );
  wp_enqueue_style( 'lato'             , '//fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic'         , array(), '' );
  wp_enqueue_style( 'nova-square'      , '//fonts.googleapis.com/css?family=Nova+Square'                                            , array(), '' );
  wp_enqueue_style( 'strait'           , '//fonts.googleapis.com/css?family=Strait'                                                 , array(), '' );
  wp_enqueue_style( 'yanone-kaffeesatz', '//fonts.googleapis.com/css?family=Yanone+Kaffeesatz:400,300,700'                          , array(), '' );
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
