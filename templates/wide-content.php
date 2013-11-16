<?php
/**
 * Displays content for the "Wide" template.
 *
 * @package Flint
 * @since 1.1.0
 */
?>

  <div class="row">
    <article id="post-<?php the_ID(); ?>" <?php post_class('col-lg-12 col-md-12 col-sm-12'); ?>>
      <header class="entry-header">
        <h1 class="entry-title"><?php if (is_singular()) { echo the_title(); } else { $permalink = get_permalink(); $title = get_the_title(); echo '<a href="' . $permalink .'" rel="bookmark">' . $title . '</a>'; } ?></h1>
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
      
      <?php if ( current_user_can('edit_posts') ) { ?><a class="btn btn-default btn-sm" href="<?php echo get_edit_post_link(); ?>">Edit</a><?php } ?>
    </article><!-- #page-<?php the_ID(); ?> -->
    
  </div><!-- .row -->
