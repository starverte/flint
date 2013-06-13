<?php
/**
 * @package Flint
 */
?>

<?php if ( is_user_logged_in() & is_single() ) { ?>
	<div class="container-fluid"><div class="row-fluid"><a class="btn btn-small" href="<?php echo get_edit_post_link(); ?>" style="float:right;">Edit</a></div></div>
<?php } ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
	<div class="entry-summary">
		<blockquote class="pull-right"><?php the_excerpt(); ?></blockquote>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
		<blockquote class="pull-right"><?php flint_the_content(); ?></blockquote>
		<?php
			flint_link_pages( array(
				'before' => '<div class="pagination"><ul>',
				'after'  => '</ul></div>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php endif; ?>

	<footer class="entry-meta clearfix">
  	<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php flint_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<span class="cat-links">
      	Posted in
				<?php if ( flint_categorized_blog() ) {
					$categories = get_the_category();
					$separator = ' ';
					$output = '';
					if($categories){
						foreach($categories as $category) {
							$output .= '<a class="badge" href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
						}
						echo trim($output, $separator);
					}
				} ?>
			</span>
      
			<span class="sep"> | </span>
			<span class="tags-links">
				Tagged
				<?php
        $tags = get_the_tags();
				$separator = ' ';
				$output = '';
				if($tags){
					foreach($tags as $tag) {
						$output .= '<a class="badge badge-inverse" href="'.get_tag_link( $tag->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $tag->name ) ) . '">'.$tag->name.'</a>'.$separator;
					}
					echo trim($output, $separator);
				}?>
			</span>
		<?php endif; // End if 'post' == get_post_type() ?>

	</footer><!-- .entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->