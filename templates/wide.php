<?php
/**
 * Template Name: Wide
 *
 * @package Flint
 * @since 1.1.0
 */
get_header(); ?>

  <div id="primary" class="content-area container">
    <div id="content" class="site-content" role="main">

      <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('col-lg-12 col-md-12 col-sm-12'); ?>>
          <?php if (has_post_thumbnail()) { the_post_thumbnail(); } ?>
          
          <header class="entry-header">
            <h1 class="entry-title"><?php if (is_singular()) { echo the_title(); } else { $permalink = get_permalink(); $title = get_the_title(); echo '<a href="' . $permalink .'" rel="bookmark">' . $title . '</a>'; } ?></h1>
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
            ) ); ?>
          </div><!-- .entry-content -->
          <?php endif; ?>
          
          
        </article><!-- #page-<?php the_ID(); ?> -->
        
        <div class="clearfix"></div>
        
				<div style="margin:1em 0;"><?php if ( current_user_can('edit_posts') ) { ?><a class="btn btn-default btn-sm" href="<?php echo get_edit_post_link(); ?>">Edit</a><?php } ?></div>
        
        <?php
          // If comments are open or we have at least one comment, load up the comment template
          if ( comments_open() || '0' != get_comments_number() )
            comments_template(); ?>

      <?php endwhile; // end of the loop. ?>

    </div><!-- #content -->
  </div><!-- #primary -->

<?php get_template_part('widgets','footer'); ?>
<?php get_footer(); ?>
