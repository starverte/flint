/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
  // Site title and description.
  wp.customize( 'blogname', function( value ) {
    value.bind( function( to ) {
      $( '.site-title a' ).text( to );
    } );
  } );
  wp.customize( 'blogdescription', function( value ) {
    value.bind( function( to ) {
      $( '.site-description' ).text( to );
    } );
  } );
  // Header text color.
  wp.customize( 'header_textcolor', function( value ) {
    value.bind( function( to ) {
      $( '.site-title a, .site-description' ).css( 'color', to );
    } );
  } );
  // Canvas colors
  wp.customize( 'flint_colors[canvas]', function( value ) {
    value.bind( function( to ) {
      $( '.navbar-inverse, #masthead, #colophon' ).css( 'background-color', to );
    } );
  } );
	wp.customize( 'flint_colors[canvas-text]', function( value ) {
    value.bind( function( to ) {
      $( '.navbar-inverse, #masthead, #colophon' ).css( 'color', to );
    } );
  } );
	wp.customize( 'flint_colors[canvas-link]', function( value ) {
    value.bind( function( to ) {
      $( '.navbar-inverse a, #masthead a, #colophon a' ).css( 'color', to );
    } );
  } );
} )( jQuery );