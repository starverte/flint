<?php
/**
 * Chat Post Format Template
 *
 * The template for displaying the post content for chat posts
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
      <header class="entry-header">
        <h1 class="entry-title"><?php if (is_single()) { echo the_title(); } else { $permalink = get_permalink(); $title = get_the_title(); echo '<a href="' . $permalink .'" rel="bookmark">' . $title . '</a>'; } ?></h1>
        <?php if ( current_user_can('edit_posts') ) { ?><a class="btn btn-default btn-sm btn-edit hidden-xs" href="<?php echo get_edit_post_link(); ?>">Edit Chat</a><?php } ?>
        
        <?php if ( 'post' == get_post_type() ) : ?>
          <div class="entry-meta">
            <?php do_action('flint_entry_meta_above_post'); ?>
          </div><!-- .entry-meta -->
        <?php endif; ?>
      </header><!-- .entry-header -->
      
      <?php if ( is_search() ) : ?>
      <div class="entry-summary">
        <div class="well"><?php the_excerpt(); ?></div>
      </div><!-- .entry-summary -->
      <?php else : ?>
      <div class="entry-content">
        <div class="well"><?php flint_the_content(); ?></div>
        <?php
        flint_link_pages( array(
          'before' => '<ul class="pagination">',
          'after'  => '</ul>',
        ) ); ?>
      </div><!-- .entry-content -->
      <?php endif; ?>
      
      <footer class="entry-meta clearfix">
        <?php do_action('flint_entry_meta_below_post'); ?>
      </footer><!-- .entry-meta -->
    </article><!-- #post-<?php the_ID(); ?> -->
    <?php if (!is_active_sidebar('left') &&  !is_active_sidebar('right') && has_post_thumbnail()) { ?><div class="col-lg-2 col-md-2 col-sm-2"></div><?php } ?>
  </div><!-- .row -->
