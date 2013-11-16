<?php
/**
 * The template for displaying the front page
 *
 * Template file used to render the Site Front Page,
 * whether the front page displays the Blog Posts Index
 * or a static page.
 *
 * @package Flint
 * @since 1.1.0
 *
 */

get_header(); ?>

  <div id="primary" class="content-area container">
    <div id="content" class="site-content" role="main">
  
      <?php while ( have_posts() ) : the_post(); ?>
  
        <?php get_template_part( 'format', get_post_format() ); ?>
  
      <?php endwhile; ?>
      
      <?php flint_content_nav( 'nav-below' ); ?>
  
    </div><!-- #content .site-content -->
  </div><!-- #primary .content-area -->

<?php flint_get_widgets('footer'); ?>
<?php get_footer(); ?>
