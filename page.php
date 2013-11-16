<?php
/**
 * The default page template
 *
 * @package Flint
 * @since 1.1.0
 */

get_header(); ?>

  <div id="primary" class="content-area container">
    <div id="content" class="site-content" role="main">
  
      <?php while ( have_posts() ) : the_post(); ?>
  
        <?php get_template_part( 'templates/' . flint_get_template(), 'content' ); ?>
  
        <?php if ( comments_open() || '0' != get_comments_number() ) { comments_template(); } ?>
  
      <?php endwhile; ?>
  
    </div><!-- #content -->
  </div><!-- #primary -->

<?php flint_get_widgets('footer'); ?>
<?php get_footer(); ?>
