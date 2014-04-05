<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Flint
 * @since 1.2.0
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function flint_page_menu_args( $args ) {
  $args['show_home'] = true;
  return $args;
}
add_filter( 'wp_page_menu_args', 'flint_page_menu_args' );

/**
 * Adds a class of group-blog to blogs with more than 1 published author
 */
function flint_body_class_multi_author( $classes ) {
  if ( is_multi_author() ) { $classes[] = 'group-blog'; }
  return $classes;
}
add_filter( 'body_class', 'flint_body_class_multi_author' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 */
function flint_attachment_link( $url, $id ) {
  if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
    return $url;

  $image = get_post( $id );
  if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
    $url .= '#main';

  return $url;
}
add_filter( 'attachment_link', 'flint_attachment_link', 10, 2 );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 */
function flint_wp_title( $title, $sep ) {
  global $page, $paged;

  if ( is_feed() )
    return $title;

  $title .= get_bloginfo( 'name' );// Add the blog name

  $site_description = get_bloginfo( 'description', 'display' );
  if ( $site_description && ( is_home() || is_front_page() ) )
    $title .= " $sep $site_description";// Add the blog description for the home/front page.

  if ( $paged >= 2 || $page >= 2 )
    $title .= " $sep " . sprintf( __( 'Page %s', 'flint' ), max( $paged, $page ) );// Add a page number if necessary

  return $title;
}
add_filter( 'wp_title', 'flint_wp_title', 10, 2 );
