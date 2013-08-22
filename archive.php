<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Flint
 */

get_header(); ?>

  <section id="primary" class="content-area container">
    <div id="content" class="site-content" role="main">

    <?php if ( have_posts() ) : ?>

      <header class="page-header">
        <h1 class="page-title">
          <?php
            if ( is_category() ) :
              printf( __( '%s', 'flint' ), '<span>' . single_cat_title( '', false ) . '</span>' );

            elseif ( is_tag() ) :
              printf( __( '%s', 'flint' ), '<span>' . single_tag_title( '', false ) . '</span>' );

            elseif ( is_author() ) :
              /* Queue the first post, that way we know
               * what author we're dealing with (if that is the case).
              */
              the_post();
              printf( __( '%s', 'flint' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' );
              /* Since we called the_post() above, we need to
               * rewind the loop back to the beginning that way
               * we can run the loop properly, in full.
               */
              rewind_posts();

            elseif ( is_day() ) :
              printf( __( '%s', 'flint' ), '<span>' . get_the_date() . '</span>' );

            elseif ( is_month() ) :
              printf( __( '%s', 'flint' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

            elseif ( is_year() ) :
              printf( __( '%s', 'flint' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

            elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
              _e( 'Asides', 'flint' );

            elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
              _e( 'Images', 'flint');

            elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
              _e( 'Videos', 'flint' );

            elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
              _e( 'Quotes', 'flint' );

            elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
              _e( 'Links', 'flint' );

            else :
              _e( 'Archives', 'flint' );

            endif;
          ?>
        </h1>
        <?php
          if ( is_category() ) :
            // show an optional category description
            $category_description = category_description();
            if ( ! empty( $category_description ) ) :
              echo apply_filters( 'category_archive_meta', '<div class="taxonomy-description">' . $category_description . '</div>' );
            endif;

          elseif ( is_tag() ) :
            // show an optional tag description
            $tag_description = tag_description();
            if ( ! empty( $tag_description ) ) :
              echo apply_filters( 'tag_archive_meta', '<div class="taxonomy-description">' . $tag_description . '</div>' );
            endif;

          endif;
        ?>
      </header><!-- .page-header -->

      <?php /* Start the Loop */ ?>
      <?php while ( have_posts() ) : the_post(); ?>

        <?php get_template_part( 'format', get_post_format() ); ?>

      <?php endwhile; ?>

      <?php flint_content_nav( 'nav-below' ); ?>

    <?php else : ?>

      <?php get_template_part( 'no-results', 'archive' ); ?>

    <?php endif; ?>

    </div><!-- #content -->
  </section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
