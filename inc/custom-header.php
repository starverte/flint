<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * You can add an optional custom header image to header.php like so ...

  <?php $header_image = get_header_image();
  if ( ! empty( $header_image ) ) { ?>
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
      <img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
    </a>
  <?php } // if ( ! empty( $header_image ) ) ?>

 *
 * @package Flint
 */

/**
 * Setup the WordPress core custom header feature.
 *
 * Use add_theme_support to register support for WordPress 3.4+
 * as well as provide backward compatibility for previous versions.
 * Use feature detection of wp_get_theme() which was introduced
 * in WordPress 3.4.
 *
 * @todo Rework this function to remove WordPress 3.4 support when WordPress 3.6 is released.
 *
 * @uses flint_header_style()
 * @uses flint_admin_header_style()
 * @uses flint_admin_header_image()
 *
 * @package Flint
 */
if ( ! function_exists( 'flint_custom_header_setup' ) ) :
function flint_custom_header_setup() {
  $default_image = get_template_directory_uri();
  $args = array(
    'default-image'          => $default_image.'/img/default-header.png',
    'default-text-color'     => 'ffffff',
    'width'                  => 300,
    'height'                 => 300,
    'flex-height'            => true,
    'wp-head-callback'       => 'flint_header_style',
    'admin-head-callback'    => 'flint_admin_header_style',
    'admin-preview-callback' => 'flint_admin_header_image',
  );

  $args = apply_filters( 'flint_custom_header_args', $args );

  if ( function_exists( 'wp_get_theme' ) ) {
    add_theme_support( 'custom-header', $args );
  }
}
endif;
add_action( 'after_setup_theme', 'flint_custom_header_setup' );

/**
 * Shiv for get_custom_header().
 *
 * get_custom_header() was introduced to WordPress
 * in version 3.4. To provide backward compatibility
 * with previous versions, we will define our own version
 * of this function.
 *
 * @todo Remove this function when WordPress 3.6 is released.
 * @return stdClass All properties represent attributes of the curent header image.
 *
 * @package Flint
 */

if ( ! function_exists( 'get_custom_header' ) ) {
  function get_custom_header() {
    return (object) array(
      'url'           => get_header_image(),
      'thumbnail_url' => get_header_image(),
      'width'         => HEADER_IMAGE_WIDTH,
      'height'        => HEADER_IMAGE_HEIGHT,
    );
  }
}

if ( ! function_exists( 'flint_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see flint_custom_header_setup().
 */
function flint_header_style() {

  // If no custom options for text are set, let's bail
  // get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value
  if ( HEADER_TEXTCOLOR == get_header_textcolor() )
    return;
  // If we get this far, we have custom styles. Let's do this.
  ?>
  <style type="text/css">
  <?php
    // Has the text been hidden?
    if ( 'blank' == get_header_textcolor() ) :
  ?>
    .site-title,
    .site-description {
      position: absolute !important;
      clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
      clip: rect(1px, 1px, 1px, 1px);
    }
  <?php
    // If the user has set a custom color for the text use that
    else :
  ?>
    .site-title a,
    .site-description {
      color: #<?php echo get_header_textcolor(); ?>;
    }
  <?php endif; ?>
  </style>
  <?php
}
endif; // flint_header_style

if ( ! function_exists( 'flint_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see flint_custom_header_setup().
 */
function flint_admin_header_style() {
?>
  <style type="text/css">
    @import url("http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,300,600,700");
    .row::before, .row::after {
      display: table;
      content: " ";
    }
    .row::after {
      clear: both;
    }
    .appearance_page_custom-header #heading {
      background: #222;
      border: none;
    }
    img {
      height:auto;
      max-width: 160px;
      padding-top: 10px;
      padding-bottom: 10px;
      vertical-align: middle;
      border: 0;
    }
    .col-xs-2, .col-xs-8 {
      float: left;
      position: relative;
      min-height: 1px;
      padding-right: 15px;
      padding-left: 15px;
      -webkit-box-sizing: border-box;
      -moz-box-sizing: border-box;
      box-sizing: border-box;
    }
    .col-xs-2 {
      width: 16.666666666666664%;
    }
    .col-xs-8 {
      width: 66.66666666666666%;
    }
    h1 {
      font-size: 56px!important;
      margin: .67em 0;
    }
    h2 {
      font-size: 18px!important;
    }
    h1, h2 {
      font-family: "Open Sans", sans-serif;
      font-weight: 600!important;
      line-height: 1.1;
      margin-top: 20px;
      margin-bottom: 10px;
    }
    
    
  </style>
<?php
}
endif; // flint_admin_header_style

if ( ! function_exists( 'flint_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see flint_custom_header_setup().
 */
function flint_admin_header_image() { ?>
  <div id="heading" class="row">
    <?php
    if ( 'blank' == get_header_textcolor() || '' == get_header_textcolor() )
      $style = ' style="display:none;"';
    else
      $style = ' style="color:#' . get_header_textcolor() . ';"';
    ?>
    <?php $header_image = get_header_image();
    if ( ! empty( $header_image ) ) { ?>
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" <?php if ( display_header_text() ) { ?> class="col-xs-2"<?php } ?>>
        <img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
      </a>
    <?php } /* if ( ! empty( $header_image ) ) */
    if ( display_header_text() ) { ?>
    <div class="site-branding <?php if ( ! empty( $header_image ) ) { ?>col-xs-8<?php } ?>">
      <h1 class="site-title" style="font-size: 27px;font-weight:bold;text-shadow:none;"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" style="color:#<?php echo get_header_textcolor() ?>;text-decoration: none;"><?php bloginfo( 'name' ); ?></a></h1>
      <h2 class="site-description" style="font-weight:bold;text-shadow:none;color:#<?php echo get_header_textcolor() ?>"><?php bloginfo( 'description' ); ?></h2>
    </div>
    <?php } /* if ( display_header_text() ) */ ?>
  </div>
<?php }
endif; // flint_admin_header_image
