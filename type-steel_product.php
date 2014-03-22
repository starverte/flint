<?php
/**
 * The template used for displaying custom post type content
 *
 * @package Flint
 * @since 1.1.1
 */
?>

  <div class="row">
    <article id="post-<?php the_ID(); ?>" <?php post_class('col-lg-8 col-md-8 col-sm-8'); ?>>
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
      
      <?php
        if (is_singular()) {
          steel_product_thumbnail();
        }
        else { flint_post_thumbnail( 'post', 'archive' ); }
      ?>
      
      <?php if ( is_search() ) : ?>
      <div class="entry-summary">
        <?php the_excerpt(); ?>
      </div><!-- .entry-summary -->
      <?php else : ?>
      <div class="entry-content">
        <?php flint_the_content(); ?>
      </div><!-- .entry-content -->
      <?php endif; ?>
      
      <footer class="entry-meta clearfix">
      <?php do_action('flint_entry_meta_below_'.$type); ?>     
      </footer><!-- .entry-meta -->
      
    </article><!-- #<?php echo $type; ?>-<?php the_ID(); ?> -->
    <div class="col-lg-4 col-md-4 col-sm-4"></div>
  </div><!-- .row -->
