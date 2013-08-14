<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to flint_comment() which is
 * located in the inc/template-tags.php file.
 *
 * @package Flint
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() )
  return;
?>
  <div class="col-lg-2 col-md-2 col-sm-2"></div>
  <div id="comments" class="comments-area col-lg-8 col-md-8 col-sm-8">

    <?php // You can start editing here -- including this comment! ?>
  
    <?php if ( have_comments() ) : ?>
      <h2 class="comments-title">
        <?php
          printf( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'flint' ),
            number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
        ?>
      </h2>
  
      <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
      <ul class="pager comments-nav-above">
        <li class="previous"><?php previous_comments_link( __( 'Older Comments', 'flint' ) ); ?></li>
        <li class="next"><?php next_comments_link( __( 'Newer Comments', 'flint' ) ); ?></li>
      </ul><!-- .pager -->
      <?php endif; // check for comment navigation ?>
  
      <ol class="comment-list">
        <?php
          /* Loop through and list the comments. Tell wp_list_comments()
           * to use flint_comment() to format the comments.
           * If you want to overload this in a child theme then you can
           * define flint_comment() and that will be used instead.
           * See flint_comment() in inc/template-tags.php for more.
           */
          wp_list_comments( array( 'callback' => 'flint_comment' ) );
        ?>
      </ol><!-- .comment-list -->
  
      <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
      <ul class="pager comments-nav-below">
        <li class="previous"><?php previous_comments_link( __( 'Older Comments', 'flint' ) ); ?></li>
        <li class="next"><?php next_comments_link( __( 'Newer Comments', 'flint' ) ); ?></li>
      </ul><!-- .pager -->
      <?php endif; // check for comment navigation ?>
  
    <?php endif; // have_comments() ?>
  
    <?php
      // If comments are closed and there are comments, let's leave a little note, shall we?
      if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
    ?>
      <p class="no-comments"><?php _e( 'Comments are closed.', 'flint' ); ?></p>
    <?php endif; ?>
  
    <?php flint_comment_form(); ?>

  </div><!-- #comments -->
  <div class="col-lg-2 col-md-2 col-sm-2"></div>
