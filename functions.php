<?php
/**
 * Flint functions and definitions
 *
 * @package Flint
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
  $content_width = 750; /* pixels */

/*
 * Load Jetpack compatibility file.
 */
require( get_template_directory() . '/inc/jetpack.php' );

if ( ! function_exists( 'flint_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function flint_setup() {

  /**
   * Custom template tags for this theme.
   */
  require( get_template_directory() . '/inc/template-tags.php' );

  /**
   * Custom functions that act independently of the theme templates
   */
  require( get_template_directory() . '/inc/extras.php' );

  /**
   * Customizer additions
   */
  require( get_template_directory() . '/inc/customizer.php' );
  
  /**
   * Theme Options
   */
  require_once( get_template_directory() . '/theme-options.php' );

  /**
   * Make theme available for translation
   * Translations can be filed in the /languages/ directory
   * If you're building a theme based on Flint, use a find and replace
   * to change 'flint' to the name of your theme in all the template files
   */
  load_theme_textdomain( 'flint', get_template_directory() . '/languages' );

  /**
   * Add default posts and comments RSS feed links to head
   */
  add_theme_support( 'automatic-feed-links' );

  /**
   * Enable support for Post Thumbnails on posts and pages
   *
   * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
   */
  add_theme_support( 'post-thumbnails' );

  /**
   * This theme uses wp_nav_menu() in one location.
   */
  register_nav_menus( array(
    'primary' => __( 'Primary Menu', 'flint' ),
  ) );

  /**
   * Enable support for Post Formats
   */
  add_theme_support( 'post-formats', array( 'aside', 'chat', 'gallery', 'link', 'status' ) );
  
  /**
   * Add theme support for custom CSS in the TinyMCE visual editor
   */
  add_editor_style( 'editor-style.css' );
}
endif; // flint_setup
add_action( 'after_setup_theme', 'flint_setup' );

/**
 * Setup the WordPress core custom background feature.
 *
 * Use add_theme_support to register support for WordPress 3.4+
 * as well as provide backward compatibility for WordPress 3.3
 * using feature detection of wp_get_theme() which was introduced
 * in WordPress 3.4.
 *
 * @todo Remove the 3.3 support when WordPress 3.6 is released.
 *
 * Hooks into the after_setup_theme action.
 */
function flint_register_custom_background() {
  $args = array(
    'default-color' => 'ffffff',
    'default-image' => '',
  );

  $args = apply_filters( 'flint_custom_background_args', $args );

  if ( function_exists( 'wp_get_theme' ) ) {
    add_theme_support( 'custom-background', $args );
  }
}
add_action( 'after_setup_theme', 'flint_register_custom_background' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function flint_widgets_init() {
  register_sidebar( array(
    'name'          => __( 'Footer', 'flint' ),
    'id'            => 'footer',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h1 class="widget-title">',
    'after_title'   => '</h1>',
  ) );
}
add_action( 'widgets_init', 'flint_widgets_init' );

/**
 * Gets the template for the widget area
 * Modeled after get_template_part and get_sidebar
 * get_sidebar doesn't make sense for all widget areas, so this replaces that function
 *
 */
function flint_get_widgets( $slug, $name = null ) {
  do_action( "get_sidebar", $slug, $name );
  
  $templates = array();
  $name = (string) $name;
  if ( '' !== $name )
    $templates[] = "widgets/{$slug}-{$name}.php";
  
  $templates[] = "widgets/{$slug}.php";
  
  locate_template($templates, true, false);
}

/**
 * Enqueue scripts and styles
 */
function flint_scripts() {
  
  // Load Twitter Bootstrap
  wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '3.0.0', true );
  wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/css/bootstrap.min.css', array() , '3.0.0' );

  wp_enqueue_script( 'flint-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '9f3e2cd', true );

  if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
  }

  if ( is_singular() && wp_attachment_is_image() ) {
    wp_enqueue_script( 'flint-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '4c99b2a' );
  }
  
  //Load Google Font
  $fonts = get_option( 'flint_fonts' );
  if (isset($fonts['body-font'])) {
    switch ($fonts['body-font']) {
      case 'Open Sans':
        wp_enqueue_style( 'open-sans', 'http://fonts.googleapis.com/css?family=Open+Sans:300,600,300,700,300italic,600italic,700italic', array(), theme_version() );
        break;
      case 'Oswald':
        wp_enqueue_style( 'oswald', 'http://fonts.googleapis.com/css?family=Oswald:300,400,700', array(), theme_version() );
        break;
      case 'Roboto':
        wp_enqueue_style( 'roboto', 'http://fonts.googleapis.com/css?family=Roboto:300,300italic,400,400italic,700,700italic', array(), theme_version() );
        break;
      case 'Droid Sans':
        wp_enqueue_style( 'droid-sans', 'http://fonts.googleapis.com/css?family=Droid+Sans:400,700', array(), theme_version() );
        break;
      case 'Lato':
        wp_enqueue_style( 'lato', 'http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic', array(), theme_version() );
        break;
    }
  }
  else {
    wp_enqueue_style( 'open-sans', 'http://fonts.googleapis.com/css?family=Open+Sans:300,600,300,700,300italic,600italic,700italic', array(), theme_version() );
  }
  if (isset($fonts['heading-font']) && $fonts['heading-font'] != $fonts['body-font'] ) {
    switch ($fonts['heading-font']) {
      case 'Open Sans':
        wp_enqueue_style( 'open-sans', 'http://fonts.googleapis.com/css?family=Open+Sans:300,600,300,700,300italic,600italic,700italic', array(), theme_version() );
        break;
      case 'Oswald':
        wp_enqueue_style( 'oswald', 'http://fonts.googleapis.com/css?family=Oswald:300,400,700', array(), theme_version() );
        break;
      case 'Roboto':
        wp_enqueue_style( 'roboto', 'http://fonts.googleapis.com/css?family=Roboto:300,300italic,400,400italic,700,700italic', array(), theme_version() );
        break;
      case 'Droid Sans':
        wp_enqueue_style( 'droid-sans', 'http://fonts.googleapis.com/css?family=Droid+Sans:400,700', array(), theme_version() );
        break;
      case 'Lato':
        wp_enqueue_style( 'lato', 'http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic', array(), theme_version() );
        break;
    }
  }
  
  //Load theme stylesheet
  wp_enqueue_style( 'flint-style', get_stylesheet_uri(), array(), theme_version() );
}
add_action( 'wp_enqueue_scripts', 'flint_scripts' );

function flint_admin_scripts() {
}
add_action( 'admin_enqueue_scripts', 'flint_admin_scripts' );

/**
 * Implement the Custom Header feature
 */
require( get_template_directory() . '/inc/custom-header.php' );

/**
 * Extended Walker class for use with the
 * Twitter Bootstrap toolkit Dropdown menus in Wordpress.
 * Edited to support n-levels submenu.
 * @author johnmegahan https://gist.github.com/1597994, Emanuele 'Tex' Tessore https://gist.github.com/3765640
 */
class Flint_Bootstrap_Menu extends Walker_Nav_Menu {
  function start_lvl( &$output, $depth = 0, $args = array() ) {

    $indent = str_repeat( "\t", $depth );
    $submenu = ($depth > 0) ? ' sub-menu' : '';
    $output     .= "\n$indent<ul class=\"dropdown-menu$submenu depth_$depth\">\n";

  }

  function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {


    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

    $li_attributes = '';
    $class_names = $value = '';

    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
    
    // managing divider: add divider class to an element to get a divider before it.
    $divider_class_position = array_search('divider', $classes);
    if($divider_class_position !== false){
      $output .= "<li class=\"divider\"></li>\n";
      unset($classes[$divider_class_position]);
    }
    
    $classes[] = ($args->has_children) ? 'dropdown' : '';
    $classes[] = ($item->current || $item->current_item_ancestor) ? 'active' : '';
    $classes[] = 'menu-item-' . $item->ID;
    if($depth && $args->has_children){
      $classes[] = 'dropdown-submenu';
    }


    $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
    $class_names = ' class="' . esc_attr( $class_names ) . '"';

    $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
    $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

    $output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';

    $attributes  = ! empty( $item->attr_title )         ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
    $attributes .= ! empty( $item->target )             ? ' target="' . esc_attr( $item->target     ) .'"' : '';
    $attributes .= ! empty( $item->xfn )                ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
    $attributes .= ! empty( $item->url )                ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
    $attributes .= ($depth == 0 && $args->has_children)  ? ' class="dropdown-toggle" data-toggle="dropdown"' : '';

    $item_output = $args->before;
    $item_output .= '<a'. $attributes .'>';
    $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
    $item_output .= ($depth == 0 && $args->has_children) ? ' <b class="caret"></b></a>' : '</a>';
    $item_output .= $args->after;


    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
  }
  

  function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
    //v($element);
    if ( !$element )
      return;

    $id_field = $this->db_fields['id'];

    //display this element
    if ( is_array( $args[0] ) )
      $args[0]['has_children'] = ! empty( $children_elements[$element->$id_field] );
    else if ( is_object( $args[0] ) )
      $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
    $cb_args = array_merge( array(&$output, $element, $depth), $args);
    call_user_func_array(array(&$this, 'start_el'), $cb_args);

    $id = $element->$id_field;

    // descend only when the depth is right and there are childrens for this element
    if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {

      foreach( $children_elements[ $id ] as $child ){

        if ( !isset($newlevel) ) {
          $newlevel = true;
          //start the child delimiter
          $cb_args = array_merge( array(&$output, $depth), $args);
          call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
        }
        $this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
      }
      unset( $children_elements[ $id ] );
    }

    if ( isset($newlevel) && $newlevel ){
      //end the child delimiter
      $cb_args = array_merge( array(&$output, $depth), $args);
      call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
    }

    //end this element
    $cb_args = array_merge( array(&$output, $element, $depth), $args);
    call_user_func_array(array(&$this, 'end_el'), $cb_args);

  }
}

/**
 * Returns current theme version.
 */
function theme_version() {
  $theme = wp_get_theme();
  return $theme->Version;
}

add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Returns breadcrumbs for pages
 */
function flint_breadcrumbs( $display = 'show' ) {
  switch ($display) {
    case 'show':
      global $post;
      $anc = get_post_ancestors( $post->ID );
      $anc = array_reverse( $anc );
      echo '<ol class="breadcrumb">';
      echo '<li><a href="' . get_home_url() . '">Home</a></li>';
      foreach ( $anc as $ancestor ) { echo '<li><a href="#">' . get_the_title( $ancestor ) . '</a></li>'; }
      echo '<li class="active">' . get_the_title() . '</li>';
      echo '</ol>';
      break;
    case 'clear':
      $options = get_option( 'flint_templates' );
      if ($options['clear_nav'] == 'breadcrumbs') { flint_breadcrumbs(); }
      break;
    case 'minimal':
      $options = get_option( 'flint_templates' );
      if (!empty($options['minimal_nav']) && $options['minimal_nav'] == 'breadcrumbs') { flint_breadcrumbs(); }
      break;
  }
  $options = get_option( 'flint_templates' );
  
}

/**
 * Creates custom footer from theme options
 */
function flint_custom_footer() {
  $options = get_option( 'flint_general' );
  $patterns = array(
    '/{site title}/',
    '/{site description}/',
    '/{year}/',
    '/{company}/',
    '/{phone}/',
    '/{email}/',
    '/{fax}/',
    '/{address}/'
  );
  $replacements = array(
    get_bloginfo( 'name' ),
    get_bloginfo( 'description' ),
    date('Y'),
    '<span itemprop="name">'      . $options['company'] . '</span>',
    '<span itemprop="telephone">' . $options['tel']     . '</span>',
    '<span itemprop="email">'     . $options['email']   . '</span>',
    '<span itemprop="faxNumber">' . $options['fax']     . '</span>',
    '<span id="address" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress"><span id="street" itemprop="streetAddress">' . $options['address'] . '</span><span class="comma">, </span><span id="locality" itemprop="addressLocality">' . $options['locality'] . '</span> <span id="postal-code" itemprop="postalCode">' . $options['postal_code'] . '</span></span>'
  );
  $footer = stripslashes($options['text']);
  $footer = preg_replace( $patterns, $replacements, $footer);
  echo '<div id="org" itemscope itemtype="http://schema.org/Organization">';
  echo $footer;
  echo '</div>';
}

function flint_options_css() {
  $fonts = get_option( 'flint_fonts' );
  $colors = get_option( 'flint_colors' );
  echo '<style type="text/css">'; 
  if (isset($fonts['body-font'])) {
    switch ($fonts['body-font']) {
      case 'Open Sans':
        echo 'body { font-family: "Open Sans", sans-serif; font-weight: 300; }';
        echo 'b, strong { font-weight: 700; }';
        break;
      case 'Oswald':
        echo 'body { font-family: "Oswald", sans-serif; font-weight: 300; }';
        echo 'b, strong { font-weight: 700; }';
        break;
      case 'Roboto':
        echo 'body { font-family: "Roboto", sans-serif; font-weight: 300; }';
        echo 'b, strong { font-weight: 700; }';
        break;
      case 'Droid Sans':
        echo 'body { font-family: "Droid Sans", sans-serif; font-weight: 400; }';
        echo 'b, strong { font-weight: 700; }';
        break;
      case 'Lato':
        echo 'body { font-family: "Lato", sans-serif; font-weight: 300; }';
        echo 'b, strong { font-weight: 700; }';
        break;
    }
  }
  else {
    echo 'body { font-family: "Open Sans", sans-serif; font-weight: 300; }';
    echo 'b, strong { font-weight: 700; }';
  }
  if (isset($fonts['heading-font'])) {
    switch ($fonts['heading-font']) {
      case 'Open Sans':
        echo 'h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 { font-family: "Open Sans", sans-serif; font-weight: 600}';
        break;
      case 'Oswald':
        echo 'h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 { font-family: "Oswald", sans-serif; font-weight: 400}';
        break;
      case 'Roboto':
        echo 'h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 { font-family: "Roboto", sans-serif; font-weight: 400}';
        break;
      case 'Droid Sans':
        echo 'h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 { font-family: "Droid Sans", sans-serif; font-weight: 700}';
        break;
      case 'Lato':
        echo 'h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 { font-family: "Lato", sans-serif; font-weight: 400}';
        break;
    }
  }
  else {
    echo 'h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 { font-family: "Open Sans", sans-serif; font-weight: 600}';
  }
  $canvas_text = isset($colors['canvas-text']) ? $colors['canvas-text'] : '#fff' ;
  $canvas_link = isset($colors['canvas-text']) ? darkenHex($canvas_text,15) : '#d9d9d9' ;
  if (isset($colors['canvas'])) {
    $canvas = $colors['canvas'];
    $canvas_dark = darkenHex($canvas,10);
    $canvas_light = lightenHex($canvas,5);
  }
  else {
    $canvas = '#222222';
    $canvas_dark = '#000000';
    $canvas_light = '#666666';
  }
  if (isset($colors['link'])) {
    $link = $colors['link'];
    $link_hover = darkenHex($link,15);
  }
  else { $link = '#428bca'; $link_hover = '#2a6496'; }
  echo 'a {color:' . $link . ';}';
  echo 'a:hover, a:focus {color:' . $link_hover . ';}';
  echo '.canvas { background-color: ' . $canvas . '; border-color: ' . $canvas_dark . '; color: ' . $canvas_text . '; }';
  echo '.navbar-inverse .navbar-nav > li > a, .canvas a, .canvas-light a { color: ' . $canvas_link . '; }';
  echo '.canvas a:hover, .canvas-light a:hover { color: ' . $canvas_text . '; }';
  echo '.site-branding a, .site-branding a:hover { color: ' . $canvas_text . '; }';
  echo '.navbar-inverse .navbar-nav > .dropdown > a .caret { border-top-color: ' . $canvas_link . '; border-bottom-color: ' . $canvas_link . '; }';
  echo '.navbar-inverse .navbar-nav > .open > a, .navbar-inverse .navbar-nav > .open > a:hover, .navbar-inverse .navbar-nav > .open > a:focus, .navbar-inverse .navbar-nav > li > a:hover, .navbar-inverse .navbar-nav > .active > a, .navbar-inverse .navbar-nav > .active > a:hover, .navbar-inverse .navbar-nav > .active > a:focus { color: ' . $canvas_text . '; background-color: ' . $canvas_dark . ';
}';
  echo '.canvas-light { background: ' . $canvas_light . '; color: ' . $canvas_text . '; }';
  echo '</style>';
}

/**
 * Converts Hex to HSL
 */
function HexHSL( $HexColor ) {
  $HexColor    = str_replace( '#', '', $HexColor );
  
  if( strlen( $HexColor ) < 3 ) str_pad( $HexColor, 3 - strlen( $HexColor ), '0' );
  
  $Add         = strlen( $HexColor ) == 6 ? 2 : 1;
  $AA          = 0;
  $AddOn       = $Add == 1 ? ( $AA = 16 - 1 ) + 1 : 1;
  
  $Red         = round( ( hexdec( substr( $HexColor, 0, $Add ) ) * $AddOn + $AA ) / 255, 6 );
  $Green       = round( ( hexdec( substr( $HexColor, $Add, $Add ) ) * $AddOn + $AA ) / 255, 6 );
  $Blue        = round( ( hexdec( substr( $HexColor, ( $Add + $Add ) , $Add ) ) * $AddOn + $AA ) / 255, 6 );
  
  
  $HSLColor    = array( 'Hue' => 0, 'Saturation' => 0, 'Luminance' => 0 );
  
  $Minimum     = min( $Red, $Green, $Blue );
  $Maximum     = max( $Red, $Green, $Blue );
  
  $Chroma      = $Maximum - $Minimum;
  
  $HSLColor['Luminance'] = ( $Minimum + $Maximum ) / 2;
  
  if( $Chroma == 0 ) {
    $HSLColor['Luminance'] = round( $HSLColor['Luminance'], 3 );
    return $HSLColor;
  }
  
  $Range = $Chroma * 6;
  
  $HSLColor['Saturation'] = $HSLColor['Luminance'] <= 0.5 ? $Chroma / ( $HSLColor['Luminance'] * 2 ) : $Chroma / ( 2 - ( $HSLColor['Luminance'] * 2 ) );
  
  if( $Red <= 0.004 || $Green <= 0.004 || $Blue <= 0.004 )
    $HSLColor['Saturation'] = 1;
  
  if( $Maximum == $Red ) { $HSLColor['Hue'] = round( ( $Blue > $Green ? 1 - ( abs( $Green - $Blue ) / $Range ) : ( $Green - $Blue ) / $Range ), 3 ); }
  else if( $Maximum == $Green ) { $HSLColor['Hue'] = round( ( $Red > $Blue ? abs( 1 - ( 4 / 3 ) + ( abs ( $Blue - $Red ) / $Range ) ) : ( 1 / 3 ) + ( $Blue - $Red ) / $Range ), 3 ); }
  else { $HSLColor['Hue'] = round( ( $Green < $Red ? 1 - 2 / 3 + abs( $Red - $Green ) / $Range : 2 / 3 + ( $Red - $Green ) / $Range ), 3 ); }
  
  $HSLColor['Saturation'] = round( $HSLColor['Saturation'], 3 );
  $HSLColor['Luminance']  = round( $HSLColor['Luminance'], 3 );
  
  return $HSLColor;
}

/**
 * Converts HSL to Hex
 */
function HSLHex( $Hue = 0, $Saturation = 0, $Luminance = 0 ) {
  
  $HSLColor    = array( 'Hue' => $Hue, 'Saturation' => $Saturation, 'Luminance' => $Luminance );
  $RGBColor    = array( 'Red' => 0, 'Green' => 0, 'Blue' => 0 );
  
  
  foreach( $HSLColor as $Name => $Value ) {
    if( is_string( $Value ) && strpos( $Value, '%' ) !== false )
      $Value = round( round( (int)str_replace( '%', '', $Value ) / 100, 2 ) * 255, 0 );
    
    else if( is_float( $Value ) )
      $Value = round( $Value * 255, 0 );
    
    $Value    = (int)$Value * 1;
    $Value    = $Value > 255 ? 255 : ( $Value < 0 ? 0 : $Value );
    $ValuePct = round( $Value / 255, 6 );
    
    ${'the_'.$Name} = $ValuePct;
  }
  
  $RGBColor['Red']   = $the_Luminance;
  $RGBColor['Green'] = $the_Luminance;
  $RGBColor['Blue']  = $the_Luminance;
  
  $Radial  = $the_Luminance <= 0.5 ? $the_Luminance * ( 1.0 + $the_Saturation ) : $the_Luminance + $the_Saturation - ( $the_Luminance * $the_Saturation );
  
  if( $Radial > 0 ) {
    $Ma   = $the_Luminance + ( $the_Luminance - $Radial );
    $Sv   = round( ( $Radial - $Ma ) / $Radial, 6 );
    $Th   = $the_Hue * 6;
    $Wg   = floor( $Th );
    $Fr   = $Th - $Wg;
    $Vs   = $Radial * $Sv * $Fr;
    $Mb   = $Ma + $Vs;
    $Mc   = $Radial - $Vs;
    
    if ($Wg == 1) {
      $RGBColor['Red']   = $Mc;
      $RGBColor['Green'] = $Radial;
      $RGBColor['Blue']  = $Ma;
    }
    else if( $Wg == 2 ) {
      $RGBColor['Red']   = $Ma;
      $RGBColor['Green'] = $Radial;
      $RGBColor['Blue']  = $Mb;
    }
    else if( $Wg == 3 ) {
      $RGBColor['Red']   = $Ma;
      $RGBColor['Green'] = $Mc;
      $RGBColor['Blue']  = $Radial;
    }
    else if( $Wg == 4 ) {
      $RGBColor['Red']   = $Mb;
      $RGBColor['Green'] = $Ma;
      $RGBColor['Blue']  = $Radial;
    }
    else if( $Wg == 5 ) {
      $RGBColor['Red']   = $Radial;
      $RGBColor['Green'] = $Ma;
      $RGBColor['Blue']  = $Mc;
    }
    else {
      $RGBColor['Red']   = $Radial;
      $RGBColor['Green'] = $Mb;
      $RGBColor['Blue']  = $Ma;
    }
  }
  
  $RGBColor['Red']   = ($C = round( $RGBColor['Red'] * 255, 0 )) < 15 ? '0'.dechex( $C ) : dechex( $C );
  $RGBColor['Green'] = ($C = round( $RGBColor['Green'] * 255, 0 )) < 15 ? '0'.dechex( $C ) : dechex( $C );
  $RGBColor['Blue']  = ($C = round( $RGBColor['Blue'] * 255, 0 )) < 15 ? '0'.dechex( $C ) : dechex( $C );
  
  return $RGBColor;
}

/**
 * Darkens Hex color by defined percentage
 */
function darkenHex( $HexColor, $percent ) {
  $HSLColor = HexHSL($HexColor);
  $HSLColor['Luminance'] = $HSLColor['Luminance'] - ($percent/100);
  $HSLColor['Luminance'] = $HSLColor['Luminance'] < 0 ? 0 : $HSLColor['Luminance'];
  $RGBColor = HSLHex($HSLColor['Hue'],$HSLColor['Saturation'],$HSLColor['Luminance']);
  return '#' . $RGBColor['Red'].$RGBColor['Green'].$RGBColor['Blue'];
}

/**
 * Lightens Hex color by defined percentage
 */
function lightenHex( $HexColor, $percent ) {
  $HSLColor = HexHSL($HexColor);
  $HSLColor['Luminance'] = $HSLColor['Luminance'] + ($percent/100);
  $HSLColor['Luminance'] = $HSLColor['Luminance'] < 0 ? 0 : $HSLColor['Luminance'];
  $RGBColor = HSLHex($HSLColor['Hue'],$HSLColor['Saturation'],$HSLColor['Luminance']);
  return '#' . $RGBColor['Red'].$RGBColor['Green'].$RGBColor['Blue'];
}

/**
 * Returns slug or class for #primary based on theme options
 */
function flint_get_template( $output = 'slug', $template = '' ) {
  $options       = get_option( 'flint_templates' );
  $the_template  = get_post_meta( get_the_ID(), '_wp_page_template', true );
  
  $default_width = !empty($options['default_width']) ? $options['default_width'] : 'full';
  $clear_width   = !empty($options['clear_width'])   ? $options['clear_width']   : 'full';
  $minimal_width = !empty($options['minimal_width']) ? $options['minimal_width'] : 'full';
  
  
  if ($template == '') { $template = $the_template == 'default' ? 'templates/'. $default_width . '.php' : ($the_template == 'templates/clear.php' ? 'templates/'. $clear_width . '.php' : ($the_template == 'templates/minimal.php' ? 'templates/'. $minimal_width . '.php' : $the_template)); }
  switch ($output) {
    case 'slug':
      $slug = $the_template == 'templates/clear.php' ? $clear_width : ($the_template == 'templates/minimal.php' ? $minimal_width : $default_width) ;
      return $slug;
      break;
    case 'content':
      switch ($template) {
        case 'templates/full.php':
          echo 'col-lg-8 col-md-8 col-sm-8';
          break;
        case 'templates/slim.php':
          echo 'col-lg-4 col-md-4 col-sm-4';
          break;
        case 'templates/narrow.php':
          echo 'col-lg-6 col-md-6 col-sm-6';
          break;
        case 'templates/wide.php':
          echo 'col-lg-12 col-md-12 col-sm-12';
          break;
      }
      break;
    case 'margins':
      switch ($template) {
        case 'templates/full.php':
          echo '<div class="col-lg-2 col-md-2 col-sm-2"></div>';
          break;
        case 'templates/slim.php':
          echo '<div class="col-lg-4 col-md-4 col-sm-4"></div>';
          break;
        case 'templates/narrow.php':
          echo '<div class="col-lg-3 col-md-3 col-sm-3"></div>';
          break;
        case 'templates/wide.php':
          break;
      }
      break;
  }
}

/**
 * Returns slug or class for .widgets.widgets-footer based on theme options
 */
function flint_get_widgets_template( $output, $widget_area = 'footer' ) {
  $options = get_option( 'flint_templates' );
  switch ($widget_area) {
    case 'footer':
      if ($options['widgets_footer_width'] == 'match') {
        flint_get_template( $output );
      }
      else { flint_get_template( $output, $options['widgets_footer_width']); }
      break;
  }
}

function flint_body_class() {
  $options = get_option( 'flint_templates' );
  $template = get_post_meta( get_the_ID(), '_wp_page_template', true );
  $clear_nav   = !empty($options['clear_nav'])   ? $options['clear_nav']   : 'breadcrumbs';
  $minimal_nav = !empty($options['minimal_nav']) ? $options['minimal_nav'] : 'navbar';
  
  if ($template == 'templates/clear.php') {
    switch ($clear_nav) {
      case 'navbar':
        body_class('clear clear-nav');
        break;
      case 'breadcrumbs':
        body_class('clear clear-breadcrumbs');
        break;
    }
  }
  elseif ($template == 'templates/minimal.php') {
    switch ($minimal_nav) {
      case 'navbar':
        body_class('clear clear-nav');
        break;
      case 'breadcrumbs':
        body_class('clear clear-breadcrumbs');
        break;
    }
  }
  else { body_class(); }
}
