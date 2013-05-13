<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Flint
 */

get_header(); ?>

	<div id="primary" class="content-area span9">
		<div id="content" class="site-content" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php if (has_term('Projects', 'sp_cause_type')) {
				get_template_part( 'content', 'project' );
			}
			if (has_term('Beneficiaries', 'sp_cause_type')) {
				get_template_part( 'content', 'beneficiary' );
			}?>

			<?php flint_content_nav( 'nav-below' ); ?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() )
					comments_template();
			?>

		<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
