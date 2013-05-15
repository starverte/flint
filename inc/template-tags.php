<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Flint
 */

if ( ! function_exists( 'flint_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 */
function flint_content_nav( $nav_id ) {
	global $wp_query, $post;

	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = ( is_single() ) ? 'navigation-post' : 'navigation-paging';

	?>
	<nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo $nav_class; ?>">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'flint' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>
	
	<ul class="pager">

		<?php previous_post_link( '<li class="previous">%link</li>' ); ?>
		<?php next_post_link( '<li class="next">%link</li>' ); ?>
		
	</ul>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>
	
	<ul class="pager">
		
		<?php if ( get_next_posts_link() ) : ?>
		<li class="previous"><?php next_posts_link( __( 'Older posts', 'flint' ) ); ?></li>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<li class="next"><?php previous_posts_link( __( 'Newer posts', 'flint' ) ); ?></li>
		<?php endif; ?>
		
	</ul>
	
	<?php endif; ?>

	</nav><!-- #<?php echo esc_html( $nav_id ); ?> -->
	<?php
}
endif; // flint_content_nav

if ( ! function_exists( 'flint_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function flint_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'flint' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'flint' ), '<span class="edit-link">', '<span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer>
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment, 40 ); ?>
					<?php printf( __( '%s <span class="says">says:</span>', 'flint' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div><!-- .comment-author .vcard -->
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'flint' ); ?></em>
					<br />
				<?php endif; ?>

				<div class="comment-meta commentmetadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time datetime="<?php comment_time( 'c' ); ?>">
					<?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'flint' ), get_comment_date(), get_comment_time() ); ?>
					</time></a>
					<?php edit_comment_link( __( 'Edit', 'flint' ), '<span class="edit-link">', '<span>' ); ?>
				</div><!-- .comment-meta .commentmetadata -->
			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
			<?php
				comment_reply_link( array_merge( $args,array(
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
				) ) );
			?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for flint_comment()

if ( ! function_exists( 'flint_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function flint_posted_on() {
	printf( __( 'Posted on <a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a><span class="byline"> by <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'flint' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'flint' ), get_the_author() ) ),
		get_the_author()
	);
}
endif;
/**
 * Returns true if a blog has more than 1 category
 */
function flint_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so flint_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so flint_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in flint_categorized_blog
 */
function flint_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'flint_category_transient_flusher' );
add_action( 'save_post', 'flint_category_transient_flusher' );

/**
 *
 *
 *
 * @since Flint 1.0
 */
function flint_link_pages($args = '') {
	$defaults = array(
		'before' => '<p>' . __('Pages:'), 'after' => '</p>',
		'link_before' => '', 'link_after' => '',
		'next_or_number' => 'number', 'nextpagelink' => __('Next page'),
		'previouspagelink' => __('Previous page'), 'pagelink' => '%',
		'echo' => 1
	);

	$r = wp_parse_args( $args, $defaults );
	$r = apply_filters( 'wp_link_pages_args', $r );
	extract( $r, EXTR_SKIP );

	global $page, $numpages, $multipage, $more, $pagenow;

	$output = '';
	if ( $multipage ) {
		if ( 'number' == $next_or_number ) {
			$output .= $before;
			for ( $i = 1; $i < ($numpages+1); $i = $i + 1 ) {
				$j = str_replace('%',$i,$pagelink);
				$output .= ' ';
				if ( ($i != $page) || ((!$more) && ($page==1)) ) {
					$output .= flint_link_page($i);
				}
				else {
					$output .= '<li class="active"><a>';
				}
				$output .= $link_before . $j . $link_after . '</a></li>';
			}
			$output .= $after;
		} else {
			if ( $more ) {
				$output .= $before;
				$i = $page - 1;
				if ( $i && $more ) {
					$output .= _wp_link_page($i);
					$output .= $link_before. $previouspagelink . $link_after . '</a>';
				}
				$i = $page + 1;
				if ( $i <= $numpages && $more ) {
					$output .= _wp_link_page($i);
					$output .= $link_before. $nextpagelink . $link_after . '</a>';
				}
				$output .= $after;
			}
		}
	}

	if ( $echo )
		echo $output;

	return $output;
}
function flint_link_page( $i ) {
	global $wp_rewrite;
	$post = get_post();

	if ( 1 == $i ) {
		$url = get_permalink();
	} else {
		if ( '' == get_option('permalink_structure') || in_array($post->post_status, array('draft', 'pending')) )
			$url = add_query_arg( 'page', $i, get_permalink() );
		elseif ( 'page' == get_option('show_on_front') && get_option('page_on_front') == $post->ID )
			$url = trailingslashit(get_permalink()) . user_trailingslashit("$wp_rewrite->pagination_base/" . $i, 'single_paged');
		else
			$url = trailingslashit(get_permalink()) . user_trailingslashit($i, 'single_paged');
	}

	return '<li><a href="' . esc_url( $url ) . '">';
}
