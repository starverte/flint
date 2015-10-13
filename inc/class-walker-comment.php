<?php
/**
 * Flint_Walker_Comment class
 *
 * @package Flint
 * @since 1.5.0
 */

/**
 * HTML comment list class.
 *
 * Style comments with two-column layout.
 * Left column includes avatar, comment meta, and reply/edit buttons.
 * Right column contains comment text.
 *
 * @since 1.5.0
 * @see WordPress 4.3.1 Walker_Comment
 *
 * @uses Walker_Comment
 */
class Flint_Walker_Comment extends Walker_Comment {

	/**
	 * Output a pingback comment.
	 *
	 * @access protected
	 *
	 * @see wp_list_comments()
	 *
	 * @param object $comment The comment object.
	 * @param int    $depth   Depth of comment.
	 * @param array  $args    An array of arguments.
	 */
	protected function ping( $comment, $depth, $args ) {
		$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
?>
		<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
			<div class="comment-body">
				<?php esc_html_e( 'Pingback:', 'flint' ); ?> <?php comment_author_link(); ?> <?php flint_edit_comment_link( __( 'Edit', 'flint' ), '<span class="edit-link">', '</span>' ); ?>
			</div>
<?php
	}

	/**
	 * Output a single comment.
	 *
	 * @access protected
	 *
	 * @see wp_list_comments()
	 *
	 * @param object $comment Comment to display.
	 * @param int    $depth   Depth of comment.
	 * @param array  $args    An array of arguments.
	 */
	protected function comment( $comment, $depth, $args ) {
		if ( 'div' === $args['style'] ) {
			$tag = 'div';
			$add_below = 'comment';
		} else {
			$tag = 'li';
			$add_below = 'div-comment';
		}
?>
		<<?php echo $tag; ?> <?php comment_class( $this->has_children ? 'parent' : '' ); ?> id="comment-<?php comment_ID(); ?>">
		<?php if ( 'div' != $args['style'] ) : ?>
		<div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
		<?php endif; ?>
		<div class="comment-author vcard">
			<?php if ( 0 != $args['avatar_size'] ) {
        echo get_avatar( $comment, $args['avatar_size'] );
      }
			printf( __( '<cite class="fn">%s</cite> <span class="says">says:</span>', 'flint' ), get_comment_author_link() ); ?>
		</div>
		<?php if ( '0' == $comment->comment_approved ) : ?>
		<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'flint' ) ?></em>
		<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', 'flint' ), get_comment_date(),  get_comment_time() ); ?></a><?php flint_edit_comment_link( __( 'Edit', 'flint' ), '&nbsp;&nbsp;', '' );
			?>
		</div>

		<?php comment_text( get_comment_id(), array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>

		<?php
		flint_comment_reply_link( array_merge( $args, array(
			'add_below' => $add_below,
			'depth'     => $depth,
			'max_depth' => $args['max_depth'],
			'before'    => '<div class="reply">',
			'after'     => '</div>',
		) ) );
		?>

		<?php if ( 'div' != $args['style'] ) : ?>
		</div>
		<?php endif; ?>
<?php
	}

	/**
	 * Output a comment in the HTML5 format.
	 *
	 * @access protected
	 *
	 * @see wp_list_comments()
	 *
	 * @param object $comment Comment to display.
	 * @param int    $depth   Depth of comment.
	 * @param array  $args    An array of arguments.
	 */
	protected function html5_comment( $comment, $depth, $args ) {
    $post_width = flint_post_width();
		$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
    $comment_class = 'comment media';

    if ( 'wide' === $post_width && ! is_active_sidebar( 'left' ) && ! is_active_sidebar( 'right' ) ) {
      switch ( $depth ) {
        case 1:
          $comment_class .= ' row';
          break;
        case 2:
          $comment_class .= ' col-xs-11 col-xs-offset-1 col-md-10 col-md-offset-2';
          break;
        case 3:
          $comment_class .= ' col-xs-11 col-xs-offset-1 col-xs-12 col-sm-10 col-sm-offset-2 col-md-9 col-md-offset-3';
          break;
        case 4:
          $comment_class .= ' col-xs-11 col-xs-offset-1 col-xs-12 col-sm-10 col-sm-offset-2 col-md-8 col-md-offset-4';
          break;
        default:
          $comment_class .= ' col-xs-11 col-xs-offset-1 col-xs-12 col-sm-10 col-sm-offset-2 col-md-7 col-md-offset-5';
          break;
      }
    } else {
      $comment_class .= ' row';
    }
?>
		<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent' : '' ); ?>>
			<article id="div-comment-<?php comment_ID(); ?>" class="<?php echo esc_attr( $comment_class ) ?>">

				<div class="comment-meta col-xs-3 col-md-2">
          <div class="comment-author vcard">
            <?php
            if ( 0 != $args['avatar_size'] ) {
              echo get_avatar( $comment, $args['avatar_size'], '', get_comment_author(), array( 'class' => 'media-object' ) );
            }
            ?>
          </div><!-- .comment-author -->

					<div class="comment-metadata">
						<p><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">
							<time class="hidden-sm hidden-md hidden-lg" datetime="<?php comment_time( 'c' ); ?>">
								<?php printf( _x( '%1$s<br> %2$s', '1: date, 2: time', 'flint' ), get_comment_date( 'n/j/y' ), get_comment_time() ); ?>
							</time>
							<time class="hidden-xs" datetime="<?php comment_time( 'c' ); ?>">
								<?php printf( _x( '%1$s<br> %2$s', '1: date, 2: time', 'flint' ), get_comment_date(), get_comment_time() ); ?>
							</time>
						</a></p>
					</div><!-- .comment-metadata -->

          <?php
          flint_edit_comment_link( __( 'Edit', 'flint' ), '', '' );

          flint_comment_reply_link( array_merge( $args, array(
            'add_below' => 'div-comment',
            'depth'     => $depth,
            'max_depth' => $args['max_depth'],
            'before'    => ' ',
          ) ) );
          ?>

					<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'flint' ); ?></p>
					<?php endif; ?>
				</div><!-- .comment-meta -->

				<div class="comment-content col-xs-9 col-md-10">
          <?php printf( __( '<h4>%s <span class="says">says:</span></h4>', 'flint' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
					<?php comment_text(); ?>
				</div><!-- .comment-content -->

			</article><!-- .comment-body -->
<?php
	}
}
