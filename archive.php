<?php
/**
 * The template for displaying Archive pages
 *
 * @package Flint
 * @since 1.0.1
 */

get_header();
flint_get_sidebar( 'header' );
?>

  <section id="primary" class="content-area container">

    <div class="row">

      <?php flint_get_sidebar( 'left' ); ?>

      <div id="content" role="main" <?php flint_content_class(); ?>>

      <?php if ( have_posts() ) : ?>

        <header class="page-header">
          <?php
            the_archive_title( '<h1 class="page-title">', '</h1>' );
            the_archive_description( '<div class="taxonomy-description">', '</div>' );
          ?>
        </header><!-- .page-header -->

        <?php while ( have_posts() ) : the_post(); ?>

          <?php get_template_part( 'format', get_post_format() ); ?>

        <?php endwhile; ?>

        <?php flint_content_nav( 'nav-below' ); ?>

      <?php else : ?>

        <?php get_template_part( 'no-results', 'archive' ); ?>

      <?php endif; ?>

      </div><!-- #content -->

      <?php flint_get_sidebar( 'right' ); ?>

    </div><!-- .row -->

  </section><!-- #primary -->

</div><!-- #page -->

<?php flint_get_sidebar( 'footer' ); ?>
<?php get_footer(); ?>
