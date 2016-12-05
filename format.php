<?php
/**
 * Post Template
 *
 * The template for displaying post content for default post format.
 *
 * @package Flint
 * @since 1.0.1
 */

global $wp_post_types;
$type = get_post_type();
$_type = $wp_post_types[ $type ];
?>

  <div class="row">
    <?php echo flint_post_margin( true ); ?>
    <article id="post-<?php the_ID(); ?>" <?php flint_post_class(); ?>>
      <header class="entry-header">
        <?php do_action( 'flint_open_entry_header_' . $type ); ?>

        <h2 class="entry-title"><?php
          if ( is_single() ) {
            echo the_title();
          } else {
            echo '<a href="' . get_permalink() . '" rel="bookmark">' . get_the_title() . '</a>';
          } ?></h2>
        <?php edit_post_link(
            sprintf( __( 'Edit %s', 'flint' ),  $_type->labels->singular_name ),
            '',
            '',
            0,
            'btn btn-default btn-sm btn-edit hidden-xs'
          ); ?>

        <div class="entry-meta">
          <?php do_action( 'flint_entry_meta_above_' . $type ); ?>
        </div><!-- .entry-meta -->

        <?php do_action( 'flint_close_entry_header_' . $type ); ?>

      </header><!-- .entry-header -->

      <?php if ( is_search() ) : ?>
      <div class="entry-summary">
        <?php the_excerpt(); ?>
      </div><!-- .entry-summary -->
      <?php else : ?>
      <div class="entry-content">
        <?php flint_the_content(); ?>
        <?php
        flint_link_pages( array(
          'before' => '<ul class="pagination">',
          'after'  => '</ul>',
        ) ); ?>
      </div><!-- .entry-content -->
      <?php endif; ?>

      <footer class="entry-meta clearfix">
        <?php do_action( 'flint_entry_meta_below_post' ); ?>
      </footer><!-- .entry-meta -->
    </article><!-- #post-<?php the_ID(); ?> -->
    <?php echo flint_post_margin(); ?>
  </div><!-- .row -->
