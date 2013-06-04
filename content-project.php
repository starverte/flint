<?php
/**
 * @package Flint
 *
 */
?>

<?php if ( is_user_logged_in() ) { ?>
	<div class="container-fluid">
		<div class="row-fluid">
                	<a class="btn btn-info btn-small" href="<?php echo get_edit_post_link(); ?>" style="color:#fff;float:right;"><i class="icon-edit icon-white"></i> Edit</a>
		</div>
	</div>
<?php } ?>
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
		<?php
			flint_link_pages( array(
				'before' => '<div class="pagination"><ul>',
				'after'  => '</ul></div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-meta clearfix">
		<?php
			/* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list( __( ', ', 'flint' ) );

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', __( ', ', 'flint' ) );

			if ( ! flint_categorized_blog() ) {
				// This blog only has 1 category so we just need to worry about tags in the meta text
				if ( '' != $tag_list ) {
					$meta_text = __( 'This entry was tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'flint' );
				} else {
					$meta_text = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'flint' );
				}

			} else {
				// But this blog has loads of categories so we should probably display them here
				if ( '' != $tag_list ) {
					$meta_text = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'flint' );
				} else {
					$meta_text = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'flint' );
				}

			} // end check for categories on this blog

			printf(
				$meta_text,
				$category_list,
				$tag_list,
				get_permalink(),
				the_title_attribute( 'echo=0' )
			);
		?>

	</footer><!-- .entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->
