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
			Proudly powered by <a href="http://wordpress.org/" rel="generator" title="<?php esc_attr_e( 'A Semantic Personal Publishing Platform', 'flint' ); ?>">WordPress</a> and the <a href="http://sparks.starverte.com/" rel="generator" title="<?php esc_attr_e( 'A WordPress Development Framework', 'flint' ); ?>">Sparks Framework</a>
			<span class="sep"> | </span>
			<?php $theme = wp_get_theme(); printf( __( 'Theme: %1$s by %2$s.', 'flint' ), $theme, '<a href="'.$theme->{'Author URI'}.'" rel="designer">'.$theme->{'Author'}.'</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
