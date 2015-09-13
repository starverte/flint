<?php
/**
 * Template Name: Minimal
 *
 * @package Flint
 * @since 1.4.0
 */

get_header( 'head' );

$options = flint_get_options();
if ( empty( $options['minimal_nav'] ) || 'navbar' === $options['minimal_nav'] ) {
  get_header( 'nav' );
}

flint_get_sidebar( 'header', true );
?>

  <div id="primary" class="content-area container">

    <div class="row">

      <?php flint_get_sidebar( 'left', true ); ?>

      <div id="content" class="site-content<?php if ( flint_is_active_sidebar( 'left' ) | flint_is_active_sidebar( 'right' ) ) { echo ' col-xs-12 col-md-9'; } ?>" role="main">

        <?php while ( have_posts() ) : the_post(); ?>

          <?php flint_breadcrumbs( 'minimal' ); ?>

          <?php get_template_part( 'templates/' . flint_get_template(), 'content' ); ?>

          <?php if ( comments_open() || '0' != get_comments_number() ) { comments_template(); } ?>

        <?php endwhile; ?>

      </div><!-- #content -->

      <?php flint_get_sidebar( 'right', true ); ?>

    </div><!-- .row -->

  </div><!-- #primary -->

</div><!-- #page -->

<?php flint_get_sidebar( 'footer', true ); ?>
<?php get_footer( 'close' ); ?>
