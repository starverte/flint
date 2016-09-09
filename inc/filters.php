<?php
/**
 * Flint Filters
 *
 * @package Flint
 * @since 1.6.0
 */

/**
 * Modifies password form to use bootstrap styles
 *
 * @since 1.0.1
 */
function flint_password_form() {
  global $post;
  $label = 'pwbox-' . ( empty( $post->ID ) ? rand() : $post->ID );
  $o = __( 'To view this protected post, enter the password below:', 'flint' ) . '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post" class="form-inline"><input class="form-control pw ' . $label . '" name="post_password" type="password" placeholder="Password"><button class="btn btn-default" type="submit" name="Submit">Submit</button></form>';
  return $o;
}
add_filter( 'the_password_form', 'flint_password_form' );

/**
 * Disable default gallery style
 */
add_filter( 'use_default_gallery_style', '__return_false' );
