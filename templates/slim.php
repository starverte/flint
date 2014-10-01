<?php
/**
 * Template Name: Slim
 *
 * @package Flint
 * @since 1.2.0
 */
get_header(); ?>
<?php flint_get_widgets('header'); ?>

  <div id="primary" class="content-area container">

    <?php
      flint_get_widgets('left');

      $content_class = 'site-content';
      if ( is_active_sidebar( 'left' ) | is_active_sidebar( 'right' ) ) {
        if ( is_active_sidebar( 'left' ) && is_active_sidebar( 'right' ) ) {
          $content_class .= ' col-xs-12 col-md-6 wa-both';
        }
        else {
          if ( is_active_sidebar( 'left' ) ) {
            $content_class .= ' col-xs-12 col-md-9 wa-left';
          }
          elseif ( is_active_sidebar( 'right' ) ) {
            $content_class .= ' col-xs-12 col-md-9 wa-right';
          }
        }
      }
      else {
        $content_class .= ' col-xs-12';
      }
    ?>

    <div id="content" class="<?php echo $content_class; ?>" role="main">

      <?php while ( have_posts() ) : the_post(); ?>

        <?php get_template_part( 'templates/slim', 'content' ); ?>

        <?php if ( comments_open() || '0' != get_comments_number() ) { comments_template(); } ?>

      <?php endwhile; ?>

    </div><!-- #content -->

    <?php flint_get_widgets('right'); ?>

  </div><!-- #primary -->

<?php flint_get_widgets('footer'); ?>
<?php get_footer(); ?>
