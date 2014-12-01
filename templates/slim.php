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

    <div class="row">

      <?php flint_get_widgets('left'); ?>

      <div id="content" role="main" <?php flint_content_class(); ?>>

        <?php while ( have_posts() ) : the_post(); ?>

          <?php get_template_part( 'templates/slim', 'content' ); ?>

          <?php if ( comments_open() || '0' != get_comments_number() ) { comments_template(); } ?>

        <?php endwhile; ?>

      </div><!-- #content -->

      <?php flint_get_widgets('right'); ?>

    </div><!-- .row -->

  </div><!-- #primary -->

<?php flint_get_widgets('footer'); ?>
<?php get_footer(); ?>
