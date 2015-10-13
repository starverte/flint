<?php
/**
 * Deprecated functions for backwards compatibility
 *
 * @package Flint
 * @since 1.4.0
 */

/**
 * Mark a function as deprecated and inform when it has been used.
 *
 * There is a hook deprecated_function_run that will be called that can be used
 * to get the backtrace up to what file and function called the deprecated
 * function.
 *
 * The current behavior is to trigger a user error if WP_DEBUG is true.
 *
 * This function is to be used in every function that is deprecated.
 *
 * @since 1.4.0
 *
 * @param string $function    The function that was called.
 * @param string $version     The version of Flint that deprecated the function.
 * @param string $replacement Optional. The function that should have been called. Default null.
 */
function flint_deprecated_function( $function, $version, $replacement = null ) {

  /**
   * Filter whether to trigger an error for deprecated functions.
   *
   * @param bool $trigger Whether to trigger the error for deprecated functions. Default true.
   */
  if ( true === WP_DEBUG ) {
    if ( ! is_null( $replacement ) ) {
      trigger_error( sprintf( __( '%1$s is deprecated since Flint version %2$s! Use %3$s instead. Triggered', 'flint' ), $function, $version, $replacement ), E_USER_NOTICE );
    } else {
      trigger_error( sprintf( __( '%1$s is deprecated since Flint version %2$s with no alternative available. Triggered', 'flint' ), $function, $version ), E_USER_NOTICE );
    }
  }
}

/**
 * Mark a parameter as deprecated and inform when it has been used.
 *
 * @since 1.5.0
 *
 * @param string $function    The function that was called.
 * @param string $parameter   The parameter that was defined.
 * @param string $version     The version of Flint that deprecated the function.
 * @param string $replacement Optional. The function that should have been called. Default null.
 */
function flint_deprecated_parameter( $function, $parameter, $version, $replacement = null ) {

  /**
   * Filter whether to trigger an error for deprecated functions.
   *
   * @param bool $trigger Whether to trigger the error for deprecated functions. Default true.
   */
  if ( true === WP_DEBUG ) {
    if ( ! is_null( $replacement ) ) {
      trigger_error( sprintf( __( 'The %2$s parameter for %1$s is <strong>deprecated</strong> since Flint version %3$s! Use %4$s instead.', 'flint' ), $function, $parameter, $version, $replacement ) );
    } else {
      trigger_error( sprintf( __( 'The %2$s parameter for %1$s is <strong>deprecated</strong> since Flint version %3$s with no alternative available.', 'flint' ), $function, $parameter, $version ) );
    }
  }
}

/**
 * Gets the featured image for a post or page if not specified otherwise in theme options
 *
 * @since 1.1.0
 * @deprecated 1.3.9 Use flint_the_post_thumbnail() instead
 * @see flint_the_post_thumbnail()
 *
 * @param string $type The post type.
 * @param string $loc The current template.
 */
function flint_post_thumbnail( $type = 'post', $loc = 'single' ) {
  flint_deprecated_function( __FUNCTION__, '1.3.9', 'flint_the_post_thumbnail()' );
  flint_the_post_thumbnail();
}

/**
 * Displays the HTML content for reply to comment link.
 *
 * @since 1.0.1
 * @deprecated 1.4.0 Use flint_comment_reply_link() instead.
 * @see flint_comment_reply_link()
 *
 * @param array       $args    Optional. Override default options.
 * @param int         $comment Comment being replied to. Default current comment.
 * @param int|WP_Post $post    Post ID or WP_Post object the comment is going to be displayed on.
 *                             Default current post.
 */
function flint_reply_link( $args = array(), $comment = null, $post = null ) {
  flint_deprecated_function( __FUNCTION__, '1.4.0', 'flint_comment_reply_link()' );
  flint_get_comment_reply_link( $args, $comment, $post );
}

/**
 * Retrieve HTML content for reply to comment link.
 *
 * @since 1.0.1
 * @deprecated 1.4.0 Use flint_get_comment_reply_link() instead.
 * @see flint_get_comment_reply_link()
 *
 * @param array       $args    Optional. Override default options.
 * @param int         $comment Comment being replied to. Default current comment.
 * @param int|WP_Post $post    Post ID or WP_Post object the comment is going to be displayed on.
 *                             Default current post.
 */
function get_flint_reply_link( $args = array(), $comment = null, $post = null ) {
  flint_deprecated_function( __FUNCTION__, '1.4.0', 'flint_get_comment_reply_link()' );
  flint_get_comment_reply_link( $args, $comment, $post );
}

/**
 * Load sidebar template.
 *
 * @since 1.1.0
 * @deprecated 1.4.0 Use flint_get_sidebar() instead.
 * @see flint_get_sidebar()
 *
 * Modeled after get_template_part and get_sidebar
 * get_sidebar doesn't make sense for all widget areas, so this replaces that function
 *
 * @param string $slug    The slug of the specialised sidebar.
 * @param bool   $minimal If true, using the Minimal page template.
 */
function flint_get_widgets( $slug, $minimal = false ) {
  flint_deprecated_function( __FUNCTION__, '1.4.0', 'flint_get_sidebar()' );
  flint_get_sidebar( $slug, $minimal );
}

/**
 * Returns slug or class for .widgets.widgets-footer based on theme options
 *
 * @since 1.1.0
 * @deprecated 1.4.0 Use flint_get_sidebar_template() instead.
 * @see flint_get_sidebar_template()
 *
 * @param string $output The return type: slug, content, or margins.
 * @param string $widget_area The widget area: header, footer, left, or right.
 */
function flint_get_widgets_template( $output, $widget_area = 'footer' ) {
  flint_deprecated_function( __FUNCTION__, '1.4.0', 'flint_get_sidebar_template()' );
  flint_get_sidebar( $output, $widget_area );
}

/**
 * Whether a sidebar is in use on the Minimal page template
 *
 * @since 1.2.0
 * @deprecated 1.4.0 Use flint_is_active_sidebar() instead.
 * @see flint_is_active_sidebar()
 * @see is_active_sidebar() for other page templates
 *
 * @param string $slug Sidebar name, id or number to check.
 *
 * @return bool true if the sidebar is in use, false otherwise.
 */
function flint_is_active_widgets( $slug ) {
  flint_deprecated_function( __FUNCTION__, '1.4.0', 'flint_is_active_sidebar()' );
  return flint_is_active_sidebar( $slug );
}

/**
 * Extended Walker class for use with the
 * Twitter Bootstrap toolkit Dropdown menus in Wordpress.
 * Edited to support n-levels submenu.
 *
 * @since 1.3.0
 *
 * @author johnmegahan https://gist.github.com/1597994, Emanuele 'Tex' Tessore https://gist.github.com/3765640
 *
 * @deprecated 1.5.0 Use Flint_Walker_Nav_Menu_Navbar instead.
 */
class Flint_Bootstrap_Menu extends Walker_Nav_Menu {
  /**
   * Starts the list before the elements are added.
   *
   * @see Walker_Nav_Menu::start_lvl()
   *
   * @param string $output Passed by reference. Used to append additional content.
   * @param int    $depth  Depth of menu item. Used for padding.
   * @param array  $args   An array of arguments.
   */
  function start_lvl( &$output, $depth = 0, $args = array() ) {
    flint_deprecated_function( __CLASS__, '1.5.0', 'Flint_Walker_Nav_Menu_Navbar' );

    $indent = str_repeat( "\t", $depth );
    $submenu = ($depth > 0) ? ' sub-menu' : '';
    $output     .= "\n$indent<ul class=\"dropdown-menu$submenu depth_$depth\">\n";

  }


  /**
   * Start the element output.
   *
   * @param string $output Passed by reference. Used to append additional content.
   * @param object $item   Menu item data object.
   * @param int    $depth  Depth of menu item. Used for padding.
   * @param array  $args   An array of arguments.
   * @param int    $id     Current item ID.
   */
  function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
    flint_deprecated_function( __CLASS__, '1.5.0', 'Flint_Walker_Nav_Menu_Navbar' );

    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

    $li_attributes = '';
    $class_names = $value = '';

    $classes = empty( $item->classes ) ? array() : (array) $item->classes;

    /**
     * Managing Divider
     * Add divider class to an element to get a divider before it.
     */
    $divider_class_position = array_search( 'divider', $classes );
    if ( false !== $divider_class_position ) {
      $output .= "<li class=\"divider\"></li>\n";
      unset( $classes[ $divider_class_position ] );
    }

    $classes[] = ($args->has_children) ? 'dropdown' : '';
    $classes[] = ($item->current || $item->current_item_ancestor) ? 'active' : '';
    $classes[] = 'menu-item-' . $item->ID;
    if ( $depth && $args->has_children ) {
      $classes[] = 'dropdown-submenu';
    }

    $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
    $class_names = ' class="' . esc_attr( $class_names ) . '"';

    $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
    $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

    $output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';

    $attributes  = ! empty( $item->attr_title )         ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
    $attributes .= ! empty( $item->target )             ? ' target="' . esc_attr( $item->target ) .'"' : '';
    $attributes .= ! empty( $item->xfn )                ? ' rel="'    . esc_attr( $item->xfn ) .'"' : '';
    $attributes .= ! empty( $item->url )                ? ' href="'   . esc_attr( $item->url ) .'"' : '';
    $attributes .= ( 0 == $depth && $args->has_children )  ? ' class="dropdown-toggle" data-toggle="dropdown"' : '';

    $item_output = $args->before;
    $item_output .= '<a'. $attributes .'>';
    $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
    $item_output .= ( 0 == $depth && $args->has_children ) ? ' <b class="caret"></b></a>' : '</a>';
    $item_output .= $args->after;

    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
  }

  /**
   * Display element
   *
   * @param object $element           Menu item data object.
   * @param array  $children_elements Array of menu item data object that are children of $element.
   * @param int    $max_depth         Maximum depth of menu item.
   * @param int    $depth             Depth of menu item.
   * @param array  $args              An array of arguments.
   * @param string $output            Passed by reference. Used to append additional content.
   */
  function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
    flint_deprecated_function( __CLASS__, '1.5.0', 'Flint_Walker_Nav_Menu_Navbar' );
    if ( ! $element ) {
      return; }

    $id_field = $this->db_fields['id'];

    if ( is_array( $args[0] ) ) {
      $args[0]['has_children'] = ! empty( $children_elements[ $element->$id_field ] ); } else if ( is_object( $args[0] ) ) {
      $args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] ); }
    $cb_args = array_merge( array( &$output, $element, $depth ), $args );
    call_user_func_array( array( &$this, 'start_el' ), $cb_args );

    $id = $element->$id_field;

    /**
     * Title
     * descend only when the depth is right and there are childrens for this element
     */
    if ( ( 0 == $max_depth || $max_depth > $depth + 1 ) && isset( $children_elements[ $id ] ) ) {

      foreach ( $children_elements[ $id ] as $child ) {
        /**
         * Start the child delimiter
         */
        if ( ! isset( $newlevel ) ) {
          $newlevel = true;
          $cb_args = array_merge( array( &$output, $depth ), $args );
          call_user_func_array( array( &$this, 'start_lvl' ), $cb_args );
        }
        $this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
      }
      unset( $children_elements[ $id ] );
    }
    /**
     * End the child delimiter
     */
    if ( isset( $newlevel ) && $newlevel ) {
      $cb_args = array_merge( array( &$output, $depth ), $args );
      call_user_func_array( array( &$this, 'end_lvl' ), $cb_args );
    }

    /**
     * End this element
     */
    $cb_args = array_merge( array( &$output, $element, $depth ), $args );
    call_user_func_array( array( &$this, 'end_el' ), $cb_args );

  }
}

/**
 * Returns slug or class for #primary based on theme options
 *
 * @since 1.1.0
 * @deprecated 1.5.0
 *
 * @param string $output   The return type: slug, content, or margins.
 * @param string $template Deprecated. The page template.
 * @param bool   $a        Used for internal use only.
 */
function flint_get_template( $output = 'slug', $template = '', $a = false ) {
  switch ( $output ) {
    case 'slug':
      flint_deprecated_function( __FUNCTION__, '1.5.0', 'flint_post_width()' );
      return flint_post_width();
      break;

    case 'content':
      flint_deprecated_function( __FUNCTION__, '1.5.0', 'flint_post_width_class()' );
      echo flint_post_width_class();
      break;

    case 'margins':
      flint_deprecated_function( __FUNCTION__, '1.5.0', 'flint_post_margin()' );
      echo flint_post_margin();
      break;
  }
}

/**
 * Get content spacer
 *
 * Retrieve and display content spacers based on default post width,
 * post format, and if side widget areas are active.
 *
 * @since 1.3.0
 * @deprecated 1.5.0 Use flint_post_margin() instead.
 * @see flint_post_margin()
 *
 * @param string $side Optional. Left or right. Default null.
 */
function flint_get_spacer( $side = null ) {
  flint_deprecated_function( __FUNCTION__, '1.5.0', 'flint_post_margin()' );
  switch ( $side ) {
    case 'left':
      return flint_post_margin( true );
      break;

    default:
      return flint_post_margin();
  }
}

/**
 * Returns slug or class for .widgets.widgets-footer based on theme options
 *
 * @since 1.4.0
 * @deprecated 1.5.0
 *
 * @param string $output The return type: slug, content, or margins.
 * @param string $widget_area The widget area: header, footer, left, or right.
 */
function flint_get_sidebar_template( $output, $widget_area = 'footer' ) {
  switch ( $output ) {
    case 'slug':
      flint_deprecated_function( __FUNCTION__, '1.5.0', 'flint_post_width()' );
      return flint_post_width();
      break;

    case 'content':
      flint_deprecated_function( __FUNCTION__, '1.5.0', 'flint_post_width_class()' );
      echo flint_post_width_class();
      break;

    case 'margins':
      flint_deprecated_function( __FUNCTION__, '1.5.0', 'flint_post_margin()' );
      echo flint_post_margin();
      break;
  }
}

/**
 * Get color option values
 *
 * @since 1.3.0
 * @deprecated 1.5.0 Use flint_options_colors() instead
 * @see flint_options_colors()
 */
function flint_get_colors() {
  flint_deprecated_function( __FUNCTION__, '1.5.0', 'flint_options_colors()' );
  return flint_options_colors();
}

/**
 * Get option defaults
 *
 * @since 1.3.0
 * @deprecated 1.5.0 Use flint_options_defaults() instead
 * @see flint_options_defaults()
 */
function flint_get_option_defaults() {
  flint_deprecated_function( __FUNCTION__, '1.5.0', 'flint_options_defaults()' );
  return flint_options_defaults();
}

/**
 * Get option values
 *
 * @since 1.3.0
 * @deprecated 1.5.0 Use flint_options() instead
 * @see flint_options()
 */
function flint_get_options() {
  flint_deprecated_function( __FUNCTION__, '1.5.0', 'flint_options()' );
  return flint_options();
}

/**
 * Display comment
 *
 * @since 1.0.1
 * @deprecated 1.5.0 Use Flint_Walker_Comment instead
 * @see Flint_Walker_Comment
 */
function flint_comment() {
  flint_deprecated_function( __FUNCTION__, '1.5.0', 'Flint_Walker_Comment' );
  return;
}

/**
 * Retrieve the avatar `<img>` tag for a user, email address, MD5 hash, comment, or post.
 *
 * @since 1.0.1
 * @deprecated 1.5.0 Use get_the_avatar() instead
 * @see WordPress get_the_avatar()
 *
 * @param mixed  $id_or_email The Gravatar to retrieve. Accepts a user_id,
 *                            user email, or WP_User object.
 * @param string $size        Optional. Height and width of the avatar image file in pixels. Default 96.
 * @param string $default     Optional. URL for the default image or a default type. Accepts
 *                            'mystery' (The Oyster Man), 'blank' (transparent GIF),
 *                            or 'gravatar_default' (the Gravatar logo). Default is the value of the
 *                            'avatar_default' option, with a fallback of 'mystery'.
 * @param string $alt         Optional. Alternative text to use in &lt;img&gt; tag. Default empty.
 * @return false|string `<img>` tag for the user's avatar. False on failure.
 */
function flint_avatar( $id_or_email, $size = '96', $default = '', $alt = false ) {
  flint_deprecated_function( __FUNCTION__, '1.5.0', 'get_the_avatar()' );
  return get_the_avatar( $id_or_email, $size, $default, $alt );
}

/**
 * Converts Hex to HSL
 *
 * @since 1.1.0
 * @deprecated 1.5.0 Use flint_color_hsl() instead.
 * @see flint_color_hsl()
 *
 * @param string $color_hex A color, in hexadecimal i.e. 'ffffff'.
 *
 * @return array Hue, saturation, and luminance of the color
 */
function flint_hex_hsl( $color_hex ) {
  flint_deprecated_function( __FUNCTION__, '1.5.0', 'flint_color_hsl()' );
  return flint_color_hsl( $color_hex );
}

/**
 * Converts HSL to Hex (or RGB array)
 *
 * @since 1.1.0
 * @deprecated 1.5.0 Use flint_color_hex() instead.
 * @see flint_color_hex()
 *
 * @param double $hue The hue of the color.
 * @param double $sat The saturation of the hue.
 * @param double $lum The brightness of the hue.
 *
 * @return string A color, in hexadecimal i.e. 'ffffff'
 */
function flint_hsl_hex( $hue = 0, $sat = 0, $lum = 0 ) {
  flint_deprecated_function( __FUNCTION__, '1.5.0', 'flint_color_hex()' );
  return flint_color_hex( $hue = 0, $sat = 0, $lum = 0 );
}

/**
 * Darkens Hex color by defined percentage
 *
 * @since 1.3.0
 * @deprecated 1.5.0 Use flint_color_darken() instead.
 * @see flint_color_darken()
 *
 * @param string $color_hex A color, in hexadecimal i.e. 'ffffff'.
 * @param double $percent The percentage to darken the color.
 *
 * @return string A hexadecimal color, a darker color than $color_hex
 */
function flint_darken( $color_hex, $percent ) {
  flint_deprecated_function( __FUNCTION__, '1.5.0', 'flint_color_darken()' );
  return flint_color_darken( $color_hex, $percent );
}

/**
 * Lightens Hex color by defined percentage
 *
 * @since 1.3.0
 * @deprecated 1.5.0 Use flint_color_lighten() instead.
 * @see flint_color_lighten()
 *
 * @param string $color_hex A color, in hexadecimal i.e. 'ffffff'.
 * @param double $percent The percentage to lighten the color.
 *
 * @return string A hexadecimal color, a lighter color than $color_hex
 */
function flint_lighten( $color_hex, $percent ) {
  flint_deprecated_function( __FUNCTION__, '1.5.0', 'flint_color_lighten()' );
  return flint_color_lighten( $color_hex, $percent );
}
