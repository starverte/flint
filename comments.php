<?php
/**
 * The template for displaying Comments
 *
 * @package Flint
 * @since 1.0.1
 */

if ( post_password_required() ) {
  return;
}
?>
<div class="row">
  <?php echo flint_post_margin(); ?>
  <div id="comments" class="comments-area <?php echo flint_post_width_class(); ?>">

    <?php if ( have_comments() ) : ?>
      <h2 class="comments-title">
        <?php
          printf( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'flint' ),
            number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
        ?>
      </h2>

      <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
      <ul class="pager comments-nav-above">
        <li class="previous"><?php previous_comments_link( __( 'Older Comments', 'flint' ) ); ?></li>
        <li class="next"><?php next_comments_link( __( 'Newer Comments', 'flint' ) ); ?></li>
      </ul><!-- .pager -->
      <?php endif; ?>

      <ol class="comment-list">
        <?php wp_list_comments( array( 'avatar_size' => 400, 'walker' => new Flint_Walker_Comment ) ); ?>
      </ol><!-- .comment-list -->

      <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
      <ul class="pager comments-nav-below">
        <li class="previous"><?php previous_comments_link( __( 'Older Comments', 'flint' ) ); ?></li>
        <li class="next"><?php next_comments_link( __( 'Newer Comments', 'flint' ) ); ?></li>
      </ul><!-- .pager -->
      <?php endif; ?>

    <?php endif; ?>

    <?php
      if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
    ?>
      <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'flint' ); ?></p>
    <?php endif; ?>

    <?php flint_comment_form(); ?>

  </div><!-- #comments -->
  <?php echo flint_post_margin(); ?>
</div>
