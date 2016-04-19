<?php
/**
 * Aside post format template
 *
 * @package Flint
 * @since 1.0.1
 */

?>

  <div class="row">
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'col-xs-12' ); ?>>
      <div class="entry-content">
        <?php edit_post_link( __( 'Edit Aside', 'flint' ), '', '', 0, 'btn btn-default btn-sm btn-edit hidden-xs' ); ?>
        <blockquote><?php flint_the_content(); ?></blockquote>
      </div><!-- .entry-content -->

      <footer class="entry-meta clearfix">
        <?php flint_posted_on(); ?>
        <span class="sep"> | </span>
        <?php do_action( 'flint_entry_meta_below_post' ); ?>
      </footer><!-- .entry-meta -->
    </article><!-- #post-<?php the_ID(); ?> -->
  </div><!-- .row -->
