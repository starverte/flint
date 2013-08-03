<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package Flint
 */
?>

	</div><!-- #main -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<?php do_action( 'flint_credits' ); ?>
			Proudly powered by <a href="http://wordpress.org/" title="<?php esc_attr_e( 'A Semantic Personal Publishing Platform', 'flint' ); ?>">WordPress</a>
			<span class="sep"> | </span>
			<?php $theme = wp_get_theme(); printf( __( 'Theme: %1$s by %2$s.', 'flint' ), $theme, '<a href="'.$theme->{'Author URI'}.'">'.$theme->{'Author'}.'</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
