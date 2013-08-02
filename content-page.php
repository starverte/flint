<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Flint
 */
?>


<?php if ( current_user_can('edit_pages') ) { ?>
  	<div class="row"><a class="btn btn-default btn-small" href="<?php echo get_edit_post_link(); ?>" style="float:right;">Edit</a></div>
<?php } ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  	<div class="<?php if (featured_image_vertical()) { echo 'col-lg-2 col-sm-2'; } ?> featured-image"><?php the_post_thumbnail(); ?></div>
  	<?php if (featured_image_vertical()) { ?><div class="col-lg-10 col-sm-10" id="content-container"><?php } ?>
      <header class="entry-header">
        <h1 class="entry-title"><?php if (is_single()) { echo the_title(); } else { $permalink = get_permalink(); $title = get_the_title(); echo '<a href="' . $permalink .'" rel="bookmark">' . $title . '</a>'; } ?></h1>
      </header><!-- .entry-header -->
      
      <div class="entry-content">
        <?php the_content(); ?>
        <?php
          flint_link_pages( array(
            'before' => '<ul class="pagination">',
            'after'  => '</ul>',
          ) );
        ?>
      </div><!-- .entry-content -->
     <?php if (featured_image_vertical()) { ?></div><?php } ?>
</article><!-- #post-<?php the_ID(); ?> -->
