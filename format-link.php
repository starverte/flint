<?php
/**
 * Link Post Format Template
 *
 * The template for displaying the post content for link posts
 *
 * @package Flint
 * @since 1.2.0
 */
?>

  <div class="row">
    <?php if (!is_active_sidebar('left') &&  !is_active_sidebar('right') && has_post_thumbnail()) { ?>
      <div class="col-lg-2 col-md-2 col-sm-2">
        <?php if (is_singular()) { flint_post_thumbnail(); } else { flint_post_thumbnail( 'post', 'archive' ); } ?>
      </div>
    <?php } ?>
    <article id="post-<?php the_ID(); ?>" <?php if (!is_active_sidebar('left') &&  !is_active_sidebar('right') && has_post_thumbnail()) { post_class('col-lg-10 col-md-10 col-sm-10'); } else { post_class(); } ?>>     
      <div class="entry-content">
        <h3><?php flint_the_content(); ?></h3>
        <?php if ( current_user_can('edit_posts') ) { ?><a class="btn btn-default btn-sm btn-edit hidden-xs" href="<?php echo get_edit_post_link(); ?>">Edit Link</a><?php } ?>
      </div><!-- .entry-content -->
      
      <footer class="entry-meta clearfix">
        <?php flint_posted_on(); ?>
        <span class="sep"> | </span>
        <?php do_action('flint_entry_meta_below_post'); ?>
      </footer><!-- .entry-meta -->
    </article><!-- #post-<?php the_ID(); ?> -->
    <?php if (!is_active_sidebar('left') &&  !is_active_sidebar('right') && has_post_thumbnail()) { ?><div class="col-lg-2 col-md-2 col-sm-2"></div><?php } ?>
  </div><!-- .row -->
