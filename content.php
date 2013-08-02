<?php
/**
 * @package Flint
 */
?>

<?php if ( current_user_can('edit_posts') ) { ?>
  	<div class="row"><a class="btn btn-default btn-small" href="<?php echo get_edit_post_link(); ?>" style="float:right;">Edit</a></div>
<?php } ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  	<div class="<?php if (featured_image_vertical()) { echo 'col-lg-2 col-sm-2 hidden-sm featured-vertical'; } else {echo 'featured-horizontal';} ?>"><?php the_post_thumbnail(); ?></div>
  	<?php if (featured_image_vertical()) { ?><div class="col-lg-10 col-sm-10" id="content-container"><?php } ?>
      <header class="entry-header">
        <h1 class="entry-title"><?php if (is_single()) { echo the_title(); } else { $permalink = get_permalink(); $title = get_the_title(); echo '<a href="' . $permalink .'" rel="bookmark">' . $title . '</a>'; } ?></h1>
          
      <?php if ( 'post' == get_post_type() ) : ?>
      <div class="entry-meta">
        <?php flint_posted_on(); ?>
      </div><!-- .entry-meta -->
      <?php endif; ?>
    </header><!-- .entry-header -->

	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
		<?php flint_the_content(); ?>
		<?php
			flint_link_pages( array(
				'before' => '<ul class="pagination">',
				'after'  => '</ul>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php endif; ?>
  <?php if (featured_image_vertical()) { ?></div><?php } ?>

	<footer class="entry-meta clearfix">
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<span class="cat-links">
      	Posted in
				<?php if ( flint_categorized_blog() ) {
					$categories = get_the_category();
					$separator = ' ';
					$output = '';
					if($categories){
						foreach($categories as $category) {
							$output .= '<a class="badge" href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( 'View all posts in %s', 'flint' ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
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
						$output .= '<a class="badge badge-inverse" href="'.get_tag_link( $tag->term_id ).'" title="' . esc_attr( sprintf( __( 'View all posts in %s', 'flint' ), $tag->name ) ) . '">'.$tag->name.'</a>'.$separator;
					}
					echo trim($output, $separator);
				}?>
			</span>
		<?php endif; // End if 'post' == get_post_type() ?>

		<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
		<span class="sep"> | </span>
		<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'flint' ), __( '1 Comment', 'flint' ), __( '% Comments', 'flint' ) ); ?></span>
		<?php endif; ?>

		</footer><!-- .entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->
