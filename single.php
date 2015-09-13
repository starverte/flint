<?php
/**
 * The Template for displaying all single posts.
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

      <?php while ( have_posts() ) : the_post(); ?>

        <?php
            $type = get_post_type();
            if ( 'post' === $type ) :
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
          if ( comments_open() || '0' != get_comments_number() ) {
            comments_template();
          }
        ?>

      <?php endwhile; ?>

      </div><!-- #content -->

      <?php flint_get_sidebar( 'right' ); ?>

    </div><!-- .row -->

  </div><!-- #primary -->

</div><!-- #page -->

<?php flint_get_sidebar( 'footer' ); ?>
<?php get_footer(); ?>
