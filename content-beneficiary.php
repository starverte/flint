<?php
/**
 * @package Flint
 * @since Flint 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title">
			<?php if (is_archive()) { ?>
				 <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'flint' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
			<?php } else {
				the_title();
			}?></h1>

		<div class="entry-meta">
			<?php cause_goal(); ?>
            <div class="progress progress-striped active">
            <?php $percent = cause_raised( array( 'before' => '', 'after' => '' ) , 'percent');
			echo '<div class="bar" style="width: ' . $percent . ';"></div>';
			?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php flint_link_pages( array( 'before' => '<div class="pagination"><ul>', 'after' => '</ul></div>' ) ); ?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php edit_post_link( __( 'Edit', 'flint' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->
