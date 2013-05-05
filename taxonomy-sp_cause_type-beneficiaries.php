<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Flint
 * @since Flint 1.0
 */

get_header(); ?>

		<section id="primary" class="content-area span9">
			<div id="content" class="site-content" role="main">

			<?php global $query_string;
			query_posts( $query_string . '&orderby=rand&posts_per_page=100' );
			if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title">Beneficiaries</h1>
				</header><!-- .page-header -->

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', 'beneficiary' );
					?>

				<?php endwhile; ?>

				<?php flint_content_nav( 'nav-below' ); ?>

			<?php else : ?>

				<?php get_template_part( 'no-results', 'archive' ); ?>

			<?php endif; ?>

			</div><!-- #content .site-content -->
		</section><!-- #primary .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
