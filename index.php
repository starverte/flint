<?php
/**
 * The main template file used to display a page when nothing more specific matches a query.
 *
 * @package Flint
 * @since 1.4.0
 */

get_header();
flint_get_sidebar( 'header' );
?>

  <div id="primary" class="content-area container">

    <div class="row">

      <?php flint_get_sidebar( 'left' ); ?>

      <div id="content" role="main" <?php flint_content_class(); ?>>

      <?php if ( have_posts() ) : ?>

        <?php while ( have_posts() ) : the_post(); ?>

          <?php
            $type = get_post_type();
            if ( 'post' === $type ) :
              get_template_part( 'format', get_post_format() );
            else :
              get_template_part( 'type', $type );
            endif;
          ?>

        <?php endwhile; ?>

        <?php flint_content_nav( 'nav-below' ); ?>

      <?php else : ?>

        <?php get_template_part( 'no-results', 'index' ); ?>

      <?php endif; ?>

      </div><!-- #content -->

      <?php flint_get_sidebar( 'right' ); ?>

    </div><!-- .row -->

  </div><!-- #primary -->

</div><!-- #page -->

<?php flint_get_sidebar( 'footer' ); ?>
<?php get_footer(); ?>
