<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Flint
 * @since 1.1.1
 */

get_header(); ?>

  <div id="primary" class="content-area container">
    <div id="content" class="site-content" role="main">
  
    <?php while ( have_posts() ) : the_post(); ?>
  
      <?php
          $type = get_post_type();
          if ($type == 'post') :
            get_template_part( 'format', get_post_format() );
          else :
            get_template_part( 'type', $type );
          endif;
        ?>
  
      <?php flint_content_nav( 'nav-below' ); ?>
  
      <?php
        // If comments are open or we have at least one comment, load up the comment template
        if ( comments_open() || '0' != get_comments_number() )
          comments_template();
      ?>
  
    <?php endwhile; ?>
  
    </div><!-- #content -->
  </div><!-- #primary -->

<?php flint_get_widgets('footer'); ?>
<?php get_footer(); ?>
