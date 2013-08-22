<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package Flint
 */

get_header(); ?>

  <section id="primary" class="content-area container">
    <div id="content" class="site-content" role="main">

    <?php if ( have_posts() ) : ?>

      <header class="page-header">
        <h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'flint' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
      </header><!-- .page-header -->

      <?php /* Start the Loop */ ?>
      <?php while ( have_posts() ) : the_post(); ?>

        <?php 'post' == get_post_type()  ?  get_template_part( 'format', get_post_format() ) : get_template_part( 'type', get_post_type() ); ?>

      <?php endwhile; ?>

      <?php flint_content_nav( 'nav-below' ); ?>

    <?php else : ?>

      <?php get_template_part( 'no-results', 'search' ); ?>

    <?php endif; ?>

    </div><!-- #content -->
  </section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
