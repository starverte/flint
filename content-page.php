<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Flint
 */
?>

  <div class="row">
    <div class="col-lg-2 col-sm-2">
			<?php if (has_post_thumbnail()) { the_post_thumbnail(); } ?>
      <?php if (has_download_btn()) { the_download_btn(); } ?>
    </div>
    <article id="post-<?php the_ID(); ?>" <?php post_class('col-lg-8 col-sm-8'); ?>>
      <header class="entry-header">
        <h1 class="entry-title"><?php if (is_single()) { echo the_title(); } else { $permalink = get_permalink(); $title = get_the_title(); echo '<a href="' . $permalink .'" rel="bookmark">' . $title . '</a>'; } ?></h1>
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
      
    </article><!-- #page-<?php the_ID(); ?> -->
    <div class="col-lg-1 col-sm-1"></div>
    <?php if ( current_user_can('edit_posts') ) { ?><a class="btn btn-default btn-small col-lg-1 col-sm-1" href="<?php echo get_edit_post_link(); ?>">Edit</a><?php } ?>
  </div><!-- .row -->
