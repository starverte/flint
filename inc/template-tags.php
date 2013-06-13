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

	</nav>
	<!-- #<?php echo esc_html( $nav_id ); ?> -->
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
    <p><?php _e( 'Pingback:', 'flint' ); ?> <?php comment_author_link(); ?></p>
    <?php
    	break;
    default :
    ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
    <article id="comment-<?php comment_ID(); ?>" class="comment media">
      <div class="pull-left">
      	<?php echo flint_avatar( $comment ); ?>
      </div>
      <div class="pull-right">
        <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time datetime="<?php comment_time( 'c' ); ?>">
        <?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'flint' ), get_comment_date(), get_comment_time() ); ?>
        </time></a>
      </div>
      <div class="media-body">
        <h4 class="media-heading"><?php printf( __( '%s <span class="says">says:</span>', 'flint' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?></h4>
        <?php if ( $comment->comment_approved == '0' ) : ?>
        <em><?php _e( 'Your comment is awaiting moderation.', 'flint' ); ?></em>
        <br>
        <?php endif; ?>
        <?php comment_text(); ?>
        
      </div>
      <div class="pull-right">
				<?php flint_reply_link(array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) )); ?>
        <?php if ( current_user_can('moderate_comments') ) { ?><a class="btn btn-small" href="<?php echo get_edit_comment_link(); ?>" >Edit</a><?php } ?>
      </div>
    </article>
    
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
 * Use bootstrap pagination
 */
function flint_link_pages($args = '') {
	$defaults = array(
		'before' => '<p>', 'after' => '</p>',
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


/**
 * Modifies the_content to allow for more tag to be a bootstrap button
 */
function flint_the_content($more_link_text = 'Read more', $stripteaser = false, $flint_more_before = ' <a href="', $flint_more_class = ' class="more-link btn btn-primary">', $flint_more_after = '</a>') {
	$content = flint_get_the_content($more_link_text, $stripteaser);
	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]&gt;', $content);
	echo $content;
}


/**
 * Modifies get_the_content to allow for more tag to be a bootstrap button
 */
function flint_get_the_content($more_link_text = 'Read more', $stripteaser = false, $flint_more_before = ' <a href="', $flint_more_class = ' class="more-link btn btn-primary">', $flint_more_after = '</a>') {
	global $more, $page, $pages, $multipage, $preview;

	$post = get_post();

	if ( null === $more_link_text )
		$more_link_text = __( '(more...)' );

	$output = '';
	$hasTeaser = false;

	// If post password required and it doesn't match the cookie.
	if ( post_password_required() )
		return get_the_password_form();

	if ( $page > count($pages) ) // if the requested page doesn't exist
		$page = count($pages); // give them the highest numbered page that DOES exist

	$content = $pages[$page-1];
	if ( preg_match('/<!--more(.*?)?-->/', $content, $matches) ) {
		$content = explode($matches[0], $content, 2);
		if ( !empty($matches[1]) && !empty($more_link_text) )
			$more_link_text = strip_tags(wp_kses_no_null(trim($matches[1])));

		$hasTeaser = true;
	} else {
		$content = array($content);
	}
	if ( (false !== strpos($post->post_content, '<!--noteaser-->') && ((!$multipage) || ($page==1))) )
		$stripteaser = true;
	$teaser = $content[0];
	if ( $more && $stripteaser && $hasTeaser )
		$teaser = '';
	$output .= $teaser;
	if ( count($content) > 1 ) {
		if ( $more ) {
			$output .= '<span id="more-' . $post->ID . '"></span>' . $content[1];
		} else {
			if ( ! empty($more_link_text) )
				$output .= apply_filters( 'the_content_more_link', $flint_more_before . get_permalink() . "#more-{$post->ID}\"" . $flint_more_class . $more_link_text . $flint_more_after );
			$output = force_balance_tags($output);
		}

	}
	if ( $preview ) // preview fix for javascript bug with foreign languages
		$output =	preg_replace_callback('/\%u([0-9A-F]{4})/', '_convert_urlencoded_to_entities', $output);

	return $output;
}


/**
 * Modifies password form to use bootstrap styles
 */
function flint_password_form() {
    global $post;
    $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
    $o = __( "To view this protected post, enter the password below:" ) . '
    <form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post" class="input-append"><input class="span2' . $label . '" name="post_password" id="appendedInputButton" type="password" placeholder="Password" /><button class="btn" type="submit" name="Submit">Submit</button>
    </form>
    ';
    return $o;
}
add_filter( 'the_password_form', 'flint_password_form' );


/**
 * Modifies comment form to use bootstrap styles
 * TODO: Remove "Required fields are marked *"
 * TODO: Fix width of inputs
 * TODO: Check pattern of email address
 * TODO: Check required fields before allowing submit
 * TODO: Fix approved tags width
 */
function flint_comment_form( $args = array(), $post_id = null ) {
	global $id;

	if ( null === $post_id )
		$post_id = $id;
	else
		$id = $post_id;

	$commenter = wp_get_current_commenter();
	$user = wp_get_current_user();
	$user_identity = $user->exists() ? $user->display_name : '';

	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true' required" : '' );
	$fields =  array(
		'author' => '<p class="comment-form-author">' .
		            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" ' . $aria_req . ' placeholder="Name" required /></p>',
		'email'  => '<p class="comment-form-email">' .
		            '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" ' . $aria_req . ' placeholder="Email Address" required /></p>',
		'url'    => '<p class="comment-form-url">' .
		            '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" placeholder="Website URL" /></p>',
	);

	$required_text = sprintf( ' ' . __('Required fields are marked %s'), '<span class="required">*</span>' );
	$defaults = array(
		'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
		'comment_field'        => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
		'must_log_in'          => '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
		'logged_in_as'         => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ), get_edit_user_link(), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
		'comment_notes_before' => '<p class="comment-notes">' . __( 'Your email address will not be published.' ) . ( $req ? $required_text : '' ) . '</p>',
		'comment_notes_after'  => '<p class="form-allowed-tags">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s' ), ' <code>' . allowed_tags() . '</code>' ) . '</p>',
		'id_form'              => 'commentform',
		'id_submit'            => 'submit',
		'title_reply'          => __( 'Leave a Reply' ),
		'title_reply_to'       => __( 'Leave a Reply to %s' ),
		'cancel_reply_link'    => __( 'Cancel reply' ),
		'label_submit'         => __( 'Post Comment' ),
	);

	$args = wp_parse_args( $args, apply_filters( 'comment_form_defaults', $defaults ) );

	?>
		<?php if ( comments_open( $post_id ) ) : ?>
			<?php do_action( 'comment_form_before' ); ?>
		<div id="respond">
			<h3 id="reply-title"><?php comment_form_title( $args['title_reply'], $args['title_reply_to'] ); ?> <small><?php cancel_comment_reply_link( $args['cancel_reply_link'] ); ?></small></h3>
			<?php if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) : ?>
				<?php echo $args['must_log_in']; ?>
				<?php do_action( 'comment_form_must_log_in_after' ); ?>
			<?php else : ?>
				<form action="<?php echo site_url( '/wp-comments-post.php' ); ?>" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>">
					<?php do_action( 'comment_form_top' ); ?>
					<?php if ( is_user_logged_in() ) : ?>
						<?php echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity ); ?>
						<?php do_action( 'comment_form_logged_in_after', $commenter, $user_identity ); ?>
					<?php else : ?>
						<?php echo $args['comment_notes_before']; ?>
						<?php
							do_action( 'comment_form_before_fields' );
							foreach ( (array) $args['fields'] as $name => $field ) {
								echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";
							}
							do_action( 'comment_form_after_fields' );
							?>
					<?php endif; ?>
					<?php echo apply_filters( 'comment_form_field_comment', $args['comment_field'] ); ?>
					<?php echo $args['comment_notes_after']; ?>
					<p class="form-submit">
						<button class="btn" name="submit" type="submit" id="<?php echo esc_attr( $args['id_submit'] ); ?>"><?php echo esc_attr( $args['label_submit'] ); ?></button>
						<?php comment_id_fields( $post_id ); ?>
					</p>
					<?php do_action( 'comment_form', $post_id ); ?>
				</form>
			<?php endif; ?>
			</div><!-- #respond -->
			<?php do_action( 'comment_form_after' ); ?>
		<?php else : ?>
			<?php do_action( 'comment_form_comments_closed' ); ?>
		<?php endif; ?>
	<?php
}

/**
 * Retrieve the avatar for a user who provided a user ID or email address.
*/
function flint_avatar( $id_or_email, $size = '96', $default = '', $alt = false ) {
	if ( ! get_option('show_avatars') )
		return false;

	if ( false === $alt)
		$safe_alt = '';
	else
		$safe_alt = esc_attr( $alt );

	if ( !is_numeric($size) )
		$size = '96';

	$email = '';
	if ( is_numeric($id_or_email) ) {
		$id = (int) $id_or_email;
		$user = get_userdata($id);
		if ( $user )
			$email = $user->user_email;
	} elseif ( is_object($id_or_email) ) {
		// No avatar for pingbacks or trackbacks
		$allowed_comment_types = apply_filters( 'get_avatar_comment_types', array( 'comment' ) );
		if ( ! empty( $id_or_email->comment_type ) && ! in_array( $id_or_email->comment_type, (array) $allowed_comment_types ) )
			return false;

		if ( !empty($id_or_email->user_id) ) {
			$id = (int) $id_or_email->user_id;
			$user = get_userdata($id);
			if ( $user)
				$email = $user->user_email;
		} elseif ( !empty($id_or_email->comment_author_email) ) {
			$email = $id_or_email->comment_author_email;
		}
	} else {
		$email = $id_or_email;
	}

	if ( empty($default) ) {
		$avatar_default = get_option('avatar_default');
		if ( empty($avatar_default) )
			$default = 'mystery';
		else
			$default = $avatar_default;
	}

	if ( !empty($email) )
		$email_hash = md5( strtolower( trim( $email ) ) );

	if ( is_ssl() ) {
		$host = 'https://secure.gravatar.com';
	} else {
		if ( !empty($email) )
			$host = sprintf( "http://%d.gravatar.com", ( hexdec( $email_hash[0] ) % 2 ) );
		else
			$host = 'http://0.gravatar.com';
	}

	if ( 'mystery' == $default )
		$default = "$host/avatar/ad516503a11cd5ca435acc9bb6523536?s={$size}"; // ad516503a11cd5ca435acc9bb6523536 == md5('unknown@gravatar.com')
	elseif ( 'blank' == $default )
		$default = $email ? 'blank' : includes_url( 'images/blank.gif' );
	elseif ( !empty($email) && 'gravatar_default' == $default )
		$default = '';
	elseif ( 'gravatar_default' == $default )
		$default = "$host/avatar/?s={$size}";
	elseif ( empty($email) )
		$default = "$host/avatar/?d=$default&amp;s={$size}";
	elseif ( strpos($default, 'http://') === 0 )
		$default = add_query_arg( 's', $size, $default );

	if ( !empty($email) ) {
		$out = "$host/avatar/";
		$out .= $email_hash;
		$out .= '?s='.$size;
		$out .= '&amp;d=' . urlencode( $default );

		$rating = get_option('avatar_rating');
		if ( !empty( $rating ) )
			$out .= "&amp;r={$rating}";

		$avatar = "<img alt='{$safe_alt}' src='{$out}' class='avatar avatar-{$size} media-object' height='{$size}' width='{$size}' />";
	} else {
		$avatar = "<img alt='{$safe_alt}' src='{$default}' class='avatar avatar-{$size} media-object avatar-default' height='{$size}' width='{$size}' />";
	}

	return apply_filters('get_avatar', $avatar, $id_or_email, $size, $default, $alt);
}

/**
 * Retrieve HTML content for reply to comment link.
 *
 * The default arguments that can be override are 'add_below', 'respond_id',
 * 'reply_text', 'login_text', and 'depth'. The 'login_text' argument will be
 * used, if the user must log in or register first before posting a comment. The
 * 'reply_text' will be used, if they can post a reply. The 'add_below' and
 * 'respond_id' arguments are for the JavaScript moveAddCommentForm() function
 * parameters.
 */
function get_flint_reply_link($args = array(), $comment = null, $post = null) {
	global $user_ID;

	$defaults = array('add_below' => 'comment', 'respond_id' => 'respond', 'reply_text' => __('Reply'),
		'login_text' => __('Log in to Reply'), 'depth' => 0, 'before' => '', 'after' => '');

	$args = wp_parse_args($args, $defaults);

	if ( 0 == $args['depth'] || $args['max_depth'] <= $args['depth'] )
		return;

	extract($args, EXTR_SKIP);

	$comment = get_comment($comment);
	if ( empty($post) )
		$post = $comment->comment_post_ID;
	$post = get_post($post);

	if ( !comments_open($post->ID) )
		return false;

	$link = '';

	if ( get_option('comment_registration') && !$user_ID )
		$link = '<a rel="nofollow" class="comment-reply-login btn btn-primary btn-small" href="' . esc_url( wp_login_url( get_permalink() ) ) . '">' . $login_text . '</a>';
	else
		$link = "<a class='comment-reply-link btn btn-primary btn-small' href='" . esc_url( add_query_arg( 'replytocom', $comment->comment_ID ) ) . "#" . $respond_id . "' onclick='return addComment.moveForm(\"$add_below-$comment->comment_ID\", \"$comment->comment_ID\", \"$respond_id\", \"$post->ID\")'>$reply_text</a>";
	return apply_filters('comment_reply_link', $before . $link . $after, $args, $comment, $post);
}
/**
 * Displays the HTML content for reply to comment link.
 */
function flint_reply_link($args = array(), $comment = null, $post = null) {
	echo get_flint_reply_link($args, $comment, $post);
}
