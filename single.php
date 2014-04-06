<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Flint
 * @since 1.2.0
 */

get_header(); ?>
<?php flint_get_widgets('header'); ?>

  <div id="primary" class="content-area container">
  
    <?php flint_get_widgets('left'); ?>
    
    <div id="content" class="site-content<?php if ( is_active_sidebar( 'left' ) | is_active_sidebar( 'right' ) ) { if ( is_active_sidebar( 'left' ) && is_active_sidebar( 'right' ) ) { echo ' col-lg-6 col-md-6'; } else { echo ' col-lg-9 col-md-9'; } } ?>" role="main">
  
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
        /**
         * If comments are open or we have at least one comment, load up the comment template
         */
        if ( comments_open() || '0' != get_comments_number() )
          comments_template();
      ?>
  
    <?php endwhile; ?>
  
    </div><!-- #content -->
    
    <?php flint_get_widgets('right'); ?>
    
  </div><!-- #primary -->

<?php flint_get_widgets('footer'); ?>
<?php get_footer(); ?>
