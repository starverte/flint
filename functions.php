<?php
/**
 * Flint functions and definitions
 *
 * @package Flint
 * @version 1.2.1
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
  $content_width = 750; /* pixels */

if ( ! function_exists( 'flint_after_setup_theme' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function flint_after_setup_theme() {

  require( get_template_directory() . '/inc/template-tags.php' );
  
  require( get_template_directory() . '/inc/colors.php' );

  require( get_template_directory() . '/inc/extras.php' );

  require( get_template_directory() . '/inc/customizer.php' );

  require_once( get_template_directory() . '/theme-options.php' );

  load_theme_textdomain( 'flint', get_template_directory() . '/languages' );

  add_theme_support( 'automatic-feed-links' );

  add_theme_support( 'post-thumbnails' );
  
  add_theme_support( 'html5' );

  register_nav_menus( array(
    'primary' => __( 'Primary Menu', 'flint' ),
  ) );

  add_theme_support( 'post-formats', array( 'aside', 'chat', 'gallery', 'link', 'status' ) );

  add_editor_style( 'editor-style.css' );
  
  /**
   * Implement the Custom Background feature
   */
  $args = array(
    'default-color' => 'eeeeee',
    'default-image' => '',
  );

  $args = apply_filters( 'flint_custom_background_args', $args );

  if ( function_exists( 'wp_get_theme' ) ) {
    add_theme_support( 'custom-background', $args );
  }
  
  /**
   * Implement Custom Header feature
   */
  $default_image = get_template_directory_uri();
  $header = array(
    'default-image'          => $default_image.'/img/default-header.png',
    'default-text-color'     => 'ffffff',
    'width'                  => 300,
    'height'                 => 300,
    'flex-height'            => true,
    'flex-width'             => true,
    'wp-head-callback'       => 'flint_header_style',
    'admin-head-callback'    => 'flint_admin_header_style',
    'admin-preview-callback' => 'flint_admin_header_image',
  );

  $header = apply_filters( 'flint_custom_header_args', $header );

  if ( function_exists( 'wp_get_theme' ) ) {
    add_theme_support( 'custom-header', $header );
  }
  
  /** 
   * Add theme support for Infinite Scroll.
   * See: http://jetpack.me/support/infinite-scroll/
   */
  add_theme_support( 'infinite-scroll', array(
    'container' => 'content',
    'footer'    => 'page',
  ) );
}
endif; // flint_after_setup_theme
add_action( 'after_setup_theme', 'flint_after_setup_theme' );

/**
 * Implement the Custom Header feature
 */
require( get_template_directory() . '/inc/custom-header.php' );

/**
 * Register widgetized areas and update sidebar with default widgets
 */
function flint_widgets_init() {
  $widget_areas = array('Header','Footer','Left','Right');
  
  foreach ($widget_areas as $widget_area) {
    register_sidebar( array(
      'name'          => $widget_area,
      'id'            => strtolower($widget_area),
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget'  => '</aside>',
      'before_title'  => '<h1 class="widget-title">',
      'after_title'   => '</h1>',
    ) );
  }
}
add_action( 'widgets_init', 'flint_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function flint_enqueue_scripts() {
  
  /**
   * Load Twitter Bootstrap
   */
  wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '3.0.0', true );
  wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/css/bootstrap.min.css', array() , '3.0.0' );

  wp_enqueue_script( 'flint-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '9f3e2cd', true );

  if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
  }

  if ( is_singular() && wp_attachment_is_image() ) {
    wp_enqueue_script( 'flint-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '4c99b2a' );
  }
  
  /* 
   * Load Google Fonts
   */
  $fonts = get_option( 'flint_fonts' );
  
  $body_font    = !empty($fonts['body_font'])    ? $fonts['body_font']    : 'Open Sans';
  $heading_font = !empty($fonts['heading_font']) ? $fonts['heading_font'] : 'Open Sans';
  
  switch ($body_font) {
    case 'Open Sans':
      wp_enqueue_style( 'open-sans', '//fonts.googleapis.com/css?family=Open+Sans:300,600,300,700,300italic,600italic,700italic', array(), flint_theme_version() );
      break;
    case 'Oswald':
      wp_enqueue_style( 'oswald', '//fonts.googleapis.com/css?family=Oswald:300,400,700', array(), flint_theme_version() );
      break;
    case 'Roboto':
      wp_enqueue_style( 'roboto', '//fonts.googleapis.com/css?family=Roboto:300,300italic,400,400italic,700,700italic', array(), flint_theme_version() );
      break;
    case 'Droid Sans':
      wp_enqueue_style( 'droid-sans', '//fonts.googleapis.com/css?family=Droid+Sans:400,700', array(), flint_theme_version() );
      break;
    case 'Lato':
      wp_enqueue_style( 'lato', '//fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic', array(), flint_theme_version() );
      break;
    case 'Strait':
      wp_enqueue_style( 'strait', '//fonts.googleapis.com/css?family=Strait', array(), flint_theme_version() );
      break;
  }
  if ( $heading_font != $body_font ) {
    switch ($heading_font) {
      case 'Open Sans':
        wp_enqueue_style( 'open-sans', '//fonts.googleapis.com/css?family=Open+Sans:300,600,300,700,300italic,600italic,700italic', array(), flint_theme_version() );
        break;
      case 'Oswald':
        wp_enqueue_style( 'oswald', '//fonts.googleapis.com/css?family=Oswald:300,400,700', array(), flint_theme_version() );
        break;
      case 'Roboto':
        wp_enqueue_style( 'roboto', '//fonts.googleapis.com/css?family=Roboto:300,300italic,400,400italic,700,700italic', array(), flint_theme_version() );
        break;
      case 'Droid Sans':
        wp_enqueue_style( 'droid-sans', '//fonts.googleapis.com/css?family=Droid+Sans:400,700', array(), flint_theme_version() );
        break;
      case 'Lato':
        wp_enqueue_style( 'lato', '//fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic', array(), flint_theme_version() );
        break;
      case 'Strait':
        wp_enqueue_style( 'strait', '//fonts.googleapis.com/css?family=Strait', array(), flint_theme_version() );
        break;
    }
  }
  
  /**
   * Load theme stylesheet
   */
  wp_enqueue_style( 'flint-style', get_stylesheet_uri(), array(), flint_theme_version() );
}
add_action( 'wp_enqueue_scripts', 'flint_enqueue_scripts' );

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
    
    /**
     * Managing Divider
     * Add divider class to an element to get a divider before it.
     */
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
    if ( !$element )
      return;

    $id_field = $this->db_fields['id'];

    /**
     * Display element
     */
    if ( is_array( $args[0] ) )
      $args[0]['has_children'] = ! empty( $children_elements[$element->$id_field] );
    else if ( is_object( $args[0] ) )
      $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
    $cb_args = array_merge( array(&$output, $element, $depth), $args);
    call_user_func_array(array(&$this, 'start_el'), $cb_args);

    $id = $element->$id_field;

    /**
     * Title
     * descend only when the depth is right and there are childrens for this element
     */
    if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {

      foreach( $children_elements[ $id ] as $child ){
        /**
         * Start the child delimiter
         */
        if ( !isset($newlevel) ) {
          $newlevel = true;
          $cb_args = array_merge( array(&$output, $depth), $args);
          call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
        }
        $this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
      }
      unset( $children_elements[ $id ] );
    }
    /**
     * End the child delimiter
     */
    if ( isset($newlevel) && $newlevel ){
      $cb_args = array_merge( array(&$output, $depth), $args);
      call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
    }

    /**
     * End this element
     */
    $cb_args = array_merge( array(&$output, $element, $depth), $args);
    call_user_func_array(array(&$this, 'end_el'), $cb_args);

  }
}
add_filter( 'use_default_gallery_style', '__return_false' );
