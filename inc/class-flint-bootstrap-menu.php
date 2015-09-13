<?php
/**
 * Flint_Bootstrap_Menu class
 *
 * @package Flint
 * @since 1.4.0
 */

/**
 * Extended Walker class for use with the
 * Twitter Bootstrap toolkit Dropdown menus in Wordpress.
 * Edited to support n-levels submenu.
 * @author johnmegahan https://gist.github.com/1597994, Emanuele 'Tex' Tessore https://gist.github.com/3765640
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
   * @param array  $args   An array of arguments. @see wp_nav_menu()
   */
  function start_lvl( &$output, $depth = 0, $args = array() ) {

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
   * @param array  $args   An array of arguments. @see wp_nav_menu()
   * @param int    $id     Current item ID.
   */
  function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

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
   * @param array  $args              An array of arguments. @see wp_nav_menu()
   * @param string $output            Passed by reference. Used to append additional content.
   */
  function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
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
