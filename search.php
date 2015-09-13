<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package Flint
 * @since 1.4.0
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
        <h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'flint' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
      </header><!-- .page-header -->

      <?php while ( have_posts() ) : the_post(); ?>

        <?php
          $type = get_post_type();
          if ( 'post' === $type ) {
            get_template_part( 'format', get_post_format() );
          } elseif ( 'page' === $type ) {
            get_template_part( 'templates/' . flint_get_template(), 'content' );
          } else {
            get_template_part( 'type', get_post_type() );
          }
        ?>

      <?php endwhile; ?>

      <?php flint_content_nav( 'nav-below' ); ?>

    <?php else : ?>

      <?php get_template_part( 'no-results', 'search' ); ?>

    <?php endif; ?>

    </div><!-- #content -->

    <?php flint_get_sidebar( 'right' ); ?>

  </div><!-- .row -->

</section><!-- #primary -->

<?php flint_get_sidebar( 'footer' ); ?>
<?php get_footer(); ?>
