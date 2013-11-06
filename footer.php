<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package Flint
 * @since 1.1.0
 */
?>

<footer id="colophon" class="canvas site-footer" role="contentinfo">
  <div class="site-info container">
    <?php flint_custom_footer(); ?>
    Proudly powered by <a href="http://wordpress.org/" title="<?php esc_attr_e( 'A Semantic Personal Publishing Platform', 'flint' ); ?>">WordPress</a>
    <span class="sep"> | </span>
    <?php $theme = wp_get_theme(); printf( __( 'Theme: %1$s by %2$s.', 'flint' ), '<a href="'.$theme->get( 'ThemeURI' ).'">'.$theme.'</a>', $theme->get( 'Author' ) ); ?>
  </div><!-- .site-info -->
</footer><!-- #colophon -->

<?php get_footer( 'close' );
