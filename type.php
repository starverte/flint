<?php
/**
 * The template used for displaying custom post type content
 *
 * @package Flint
 * @since 1.1.1
 */
?>

  <div class="row">
    <?php if (!is_active_sidebar('left') &&  !is_active_sidebar('right')) { ?>
      <div class="col-xs-12 col-sm-2 col-md-2">
        <?php if (is_singular()) { flint_post_thumbnail(); } else { flint_post_thumbnail( 'post', 'archive' ); } ?>
      </div>
    <?php }
    else { ?>
      <div class="col-xs-12 col-sm-2 hidden-md hidden-lg">
        <?php if (is_singular()) { flint_post_thumbnail(); } else { flint_post_thumbnail( 'post', 'archive' ); } ?>
      </div>
    <?php } ?>
    <article id="post-<?php the_ID(); ?>" <?php flint_post_class(); ?>>
      <header class="entry-header">
        <?php $type = get_post_type(); ?>
        <?php do_action('flint_open_entry_header_'.$type); ?>

        <h1 class="entry-title"><?php if (is_singular()) { echo the_title(); } else { $permalink = get_permalink(); $title = get_the_title(); echo '<a href="' . $permalink .'" rel="bookmark">' . $title . '</a>'; } ?></h1>
        <?php if ( current_user_can('edit_posts') ) { ?><a class="btn btn-default btn-sm btn-edit hidden-xs" href="<?php echo get_edit_post_link(); ?>">Edit</a><?php } ?>

        <div class="entry-meta">
          <?php do_action('flint_entry_meta_above_'.$type); ?>
        </div><!-- .entry-meta -->

        <?php do_action('flint_close_entry_header_'.$type); ?>

      </header><!-- .entry-header -->

      <?php if ( is_search() ) : ?>
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
        ) ); ?>
      </div><!-- .entry-content -->
      <?php endif; ?>

      <footer class="entry-meta clearfix">
      <?php do_action('flint_entry_meta_below_'.$type); ?>
      </footer><!-- .entry-meta -->

    </article><!-- #post-<?php the_ID(); ?> -->
    <?php if (!is_active_sidebar('left') &&  !is_active_sidebar('right')) { ?><div class="hidden-xs col-sm-2 col-md-2"></div><?php } ?>
    <?php else { ?><div class="hidden-xs col-sm-2 hidden-md hidden-lg"></div><?php } ?>
  </div><!-- .row -->
