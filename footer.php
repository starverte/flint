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

</div><!-- #page -->

<footer id="colophon" class="canvas site-footer" role="contentinfo">
  <div class="site-info container">
    <?php flint_custom_footer(); ?>
  </div><!-- .site-info -->
</footer><!-- #colophon -->

<?php get_footer( 'close' );
