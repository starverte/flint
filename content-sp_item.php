<?php
/**
 * @package Flint
 * @since Flint 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>

		<div class="entry-meta">
			
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'flint' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
    	<?php item_ref(); ?>
       	<?php item_price(); ?>
        <?php item_shipping(); ?>
        <?php item_dimensions(); ?>
		<?php
			/* translators: used between list items, there is a space after the comma */
			$department_list = get_the_term_list( $post->ID, 'department', '', ', ', '' );

			/* translators: used between list items, there is a space after the comma */
			$keyword_list = get_the_term_list( $post->ID, 'keyword', '', ', ', '' );;

			if ( ! flint_categorized_blog() ) {
				// This blog only has 1 category so we just need to worry about tags in the meta text
				if ( '' != $department_list ) {
					$meta_text = __( 'This item\'s keywords are %2$s. Bookmark the <a href="%3$s?ref=permalink" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'flint' );
				} else {
					$meta_text = __( 'Bookmark the <a href="%3$s?ref=permalink" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'flint' );
				}

			} else {
				// But this blog has loads of categories so we should probably display them here
				if ( '' != $keyword_list ) {
					$meta_text = __( 'Listed under %1$s. This item\'s keywords are %2$s. Bookmark the <a href="%3$s?ref=permalink" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'flint' );
				} else {
					$meta_text = __( 'Listed under %1$s. Bookmark the <a href="%3$s?ref=permalink" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'flint' );
				}

			} // end check for categories on this blog

			printf(
				$meta_text,
				$department_list,
				$keyword_list,
				get_permalink(),
				the_title_attribute( 'echo=0' )
			);
		?>

		<?php edit_post_link( __( 'Edit', 'flint' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->
