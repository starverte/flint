<?php
/**
 * Deprecated functions for backwards compatibility
 *
 * @package Flint
 * @since 1.4.3
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
      trigger_error( sprintf( __( '%1$s is <strong>deprecated</strong> since Flint version %2$s! Use %3$s instead.', 'flint' ), $function, $version, $replacement ) );
    } else {
      trigger_error( sprintf( __( '%1$s is <strong>deprecated</strong> since Flint version %2$s with no alternative available.', 'flint' ), $function, $version ) );
    }
  }
}

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
 * @deprecated 1.3.9 Use flint_the_post_thumbnail
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
 * @deprecated 1.4.0 Use flint_comment_reply_link instead.
 *
 * @param array       $args    Optional. Override default options.
 * @param int         $comment Comment being replied to. Default current comment.
 * @param int|WP_Post $post    Post ID or WP_Post object the comment is going to be displayed on.
 *                             Default current post.
 * @return mixed Link to show comment form, if successful. False, if comments are closed.
 */
function flint_reply_link( $args = array(), $comment = null, $post = null ) {
  flint_deprecated_function( __FUNCTION__, '1.4.0', 'flint_comment_reply_link()' );
  flint_get_comment_reply_link( $args, $comment, $post );
}

/**
 * Retrieve HTML content for reply to comment link.
 *
 * @deprecated 1.4.0 Use flint_get_comment_reply_link instead.
 *
 * @param array       $args    Optional. Override default options.
 * @param int         $comment Comment being replied to. Default current comment.
 * @param int|WP_Post $post    Post ID or WP_Post object the comment is going to be displayed on.
 *                             Default current post.
 * @return void|false|string Link to show comment form, if successful. False, if comments are closed.
 */
function get_flint_reply_link( $args = array(), $comment = null, $post = null ) {
  flint_deprecated_function( __FUNCTION__, '1.4.0', 'flint_get_comment_reply_link()' );
  flint_get_comment_reply_link( $args, $comment, $post );
}

/**
 * Load sidebar template.
 *
 * @deprecated 1.4.0 Use flint_get_sidebar instead.
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
 * @deprecated 1.4.0 Use flint_get_sidebar_template instead.
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
 * @deprecated 1.4.0 Use flint_is_active_sidebar instead.
 *
 * @see is_active_sidebar() for other page templates
 *
 * @param string $slug Sidebar name, id or number to check.
 *
 * @return bool true if the sidebar is in use, false otherwise.
 */
function flint_is_active_widgets( $slug ) {
  flint_deprecated_function( __FUNCTION__, '1.4.0', 'flint_is_active_sidebar()' );
  flint_get_sidebar( $slug );
}

/**
 * Extended Walker class for use with the
 * Twitter Bootstrap toolkit Dropdown menus in Wordpress.
 * Edited to support n-levels submenu.
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
   * @since 1.3.0
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
   * @since 1.3.0
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
    $attributes .= ( 0 === $depth && $args->has_children )  ? ' class="dropdown-toggle" data-toggle="dropdown"' : '';

    $item_output = $args->before;
    $item_output .= '<a'. $attributes .'>';
    $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
    $item_output .= ( 0 === $depth && $args->has_children ) ? ' <b class="caret"></b></a>' : '</a>';
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
    if ( ( 0 === $max_depth || $max_depth > $depth + 1 ) && isset( $children_elements[ $id ] ) ) {

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
 * @deprecated 1.5.0
 *
 * @param string $output   The return type: slug, content, or margins.
 * @param string $template Deprecated. The page template.
 * @param bool   $a        Used for internal use only.
 */
function flint_get_template( $output = 'slug', $template = '', $a = false ) {
  $options = flint_get_options();
  $file    = get_post_meta( get_the_ID(), '_wp_page_template', true );

  if ( ! empty( $template ) && $a != true ) {
    flint_deprecated_parameter( __FUNCTION__, '$template', '1.2.1', 'get_template()' );
  }

  if ( $file == 'templates/clear.php' ) {
    $slug = $options['clear_width'];
  } elseif ( $file == 'templates/minimal.php' ) {
    if ( flint_is_active_sidebar( 'left' ) || flint_is_active_sidebar( 'right' ) ) {
      $slug = 'wide';
    } else {
      $slug = $options['minimal_width'];
    }
  } else {
    if ( is_active_sidebar( 'left' ) || is_active_sidebar( 'right' ) ) {
      $slug = 'wide';
    } else {
      $slug = $options['page_default_width'];
    }
  }

  switch ( $output ) {
    case 'slug':
      return $slug;
      break;

    case 'content':
      switch ( $slug ) {
        case 'slim':
          echo 'col-xs-12 col-sm-8 col-md-4';
          break;

        case 'narrow':
          echo 'col-xs-12 col-sm-8 col-md-6';
          break;

        case 'full':
          echo 'col-xs-12 col-sm-10 col-md-8';
          break;

        case 'wide':
          echo 'col-xs-12';
          break;
      }

      break;

    case 'margins':
      switch ( $slug ) {
        case 'slim':
          echo '<div class="hidden-xs col-sm-2 col-md-4"></div>';
          break;

        case 'narrow':
          echo '<div class="hidden-xs col-sm-2 col-md-3"></div>';
          break;

        case 'full':
          echo '<div class="hidden-xs col-sm-1 col-md-2"></div>';
          break;

        case 'wide':
          break;
      }

      break;
  }
}

/**
 * Get content spacer
 *
 * Retrieve and display content spacers based on default post width,
 * post format, and if side widget areas are active.
 *
 * @uses flint_the_post_thumbnail()
 * @uses flint_get_options()
 * @uses get_post_format()
 * @uses is_active_sidebar()
 * @uses is_single()
 * @uses is_singular()
 *
 * @param string $side Left or right. Required.
 * @var array $options The options array
 * @var string $format The format, if any, of the post
 * @var string $width The actual post width
 *
 * @todo Convert to return instead of displaying results
 */
function flint_get_spacer( $side ) {
  global $post;
  $options = flint_get_options();
  $format  = get_post_format( $post->ID );

  switch ( $format ) {
    case 'aside':
      $width = 'wide';
      break;
    case 'link':
      $width = 'wide';
      break;
    case 'status':
      $width = 'wide';
      break;
    default:
      $width = $options['post_default_width'];
      break;
  }

  if ( ! is_active_sidebar( 'left' ) && ! is_active_sidebar( 'right' ) ) {
    if ( $side == 'left' ) {
      switch ( $width ) {
        case 'slim':
          echo '<div class="hidden-xs hidden-sm col-md-2"></div>';
          echo '<div class="col-xs-12 col-sm-2 col-md-2">';

          flint_the_post_thumbnail();

          if ( ! is_single() && $format == 'gallery' ) {
            echo '<a class="btn btn-info btn-block hidden-xs" href="' . get_permalink() . '">View gallery</a>';
          }

          echo '</div>';
          break;

        case 'narrow':
          echo '<div class="hidden-xs hidden-sm col-md-1"></div>';
          echo '<div class="col-xs-12 col-sm-2 col-md-2">';

          flint_the_post_thumbnail();

          if ( ! is_single() && $format == 'gallery' ) {
            echo '<a class="btn btn-info btn-block hidden-xs" href="' . get_permalink() . '">View gallery</a>';
          }

          echo '</div>';
          break;

        case 'full':
          echo '<div class="col-xs-12 col-sm-2 col-md-2">';

          flint_the_post_thumbnail();

          if ( ! is_single() && $format == 'gallery' ) {
            echo '<a class="btn btn-info btn-block hidden-xs" href="' . get_permalink() . '">View gallery</a>';
          }

          echo '</div>';
          break;

        case 'wide':
          echo '<div class="col-xs-12 col-sm-12 hidden-md hidden-lg">';

          flint_the_post_thumbnail();

          if ( ! is_single() && $format == 'gallery' ) {
            echo '<a class="btn btn-info btn-block hidden-xs" href="' . get_permalink() . '">View gallery</a>';
          }

          echo '</div>';
          break;

        default:
          echo '<div class="col-xs-12 col-sm-2 col-md-2">';

          flint_the_post_thumbnail();

          if ( ! is_single() && $format == 'gallery' ) {
            echo '<a class="btn btn-info btn-block hidden-xs" href="' . get_permalink() . '">View gallery</a>';
          }

          echo '</div>';
          break;
      }
    } elseif ( $side == 'right' ) {
      switch ( $width ) {
        case 'slim':
          $output = '<div class="hidden-xs col-sm-2 col-md-4"></div>';
          break;
        case 'narrow':
          $output = '<div class="hidden-xs col-sm-2 col-md-3"></div>';
          break;
        case 'full':
          $output = '<div class="hidden-xs col-sm-2 col-md-2"></div>';
          break;
        case 'wide':
          $output = null;
          break;
        default:
          $output = '<div class="hidden-xs col-sm-2 col-md-2"></div>';
          break;
      }
      echo $output;
    }
  } else {
    if ( $side == 'left' ) {
      echo '<div class="col-xs-12 col-sm-12 hidden-md hidden-lg">';

      flint_the_post_thumbnail();

      echo '</div>';
    } else {
      return;
    }
  }
}

/**
 * Returns slug or class for .widgets.widgets-footer based on theme options
 *
 * @deprecated 1.5.0
 *
 * @param string $output The return type: slug, content, or margins.
 * @param string $widget_area The widget area: header, footer, left, or right.
 */
function flint_get_sidebar_template( $output, $widget_area = 'footer' ) {
  $options = flint_get_options();
  $type    = get_post_type( get_the_ID() );

  switch ( $widget_area ) {
    case 'footer':
      if ( $type == 'page' ) {
        flint_get_template( $output );
      } else {
        flint_get_template( $output, 'templates/full.php', true );
      }
      break;
  }
}
