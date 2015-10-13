<?php
/**
 * Custom template tags for this theme.
 *
 * @package Flint
 * @since 1.0.1
 */

/**
 * Display navigation to next/previous pages when applicable
 *
 * @since 1.0.1
 *
 * @param string $nav_id The slug ID of the navigation menu.
 *
 * @todo Remove in Flint 2.
 */
function flint_content_nav( $nav_id ) {
  global $wp_query;
  global $post;
  global $post_id;
  $type = get_post_type( $post_id );

  if ( is_single() ) {
    $previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
    $next = get_adjacent_post( false, '', false );

    if ( ! $next && ! $previous ) {
      return;
    }

    // Hide bottom navigation for products.
    if ( $type = 'steel_product' ) {
      return;
    }
  }

  if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) ) {
    return; }

  $nav_class = ( is_single() ) ? 'navigation-post' : 'navigation-paging';

  ?>
  <nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo esc_attr( $nav_class ); ?>">
    <h1 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'flint' ); ?></h1>

  <?php if ( is_single() ) : ?>

  <ul class="pager">

    <?php previous_post_link( '<li class="previous">%link</li>' ); ?>
    <?php next_post_link( '<li class="next">%link</li>' ); ?>

  </ul>

  <?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : ?>

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

/**
 * Display comments below post
 *
 * @since 1.1.1
 *
 * @todo Remove in Flint 2.
 */
function flint_the_comments() {
  if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
    <span class="sep"> | </span>
    <span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'flint' ), __( '1 Comment', 'flint' ), __( '% Comments', 'flint' ) ); ?></span>
  <?php endif;
}
add_action( 'flint_entry_meta_below_post', 'flint_the_comments', 20 );

if ( ! function_exists( 'flint_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since 1.0.1
 */
function flint_posted_on() {
  if ( get_the_date( 'Y' ) != date( 'Y' ) ) :
    $postdate = esc_html( get_the_date( 'F j, Y' ) );
  else :
    $postdate = esc_html( get_the_date( 'F j' ) );
  endif;
  printf( __( 'Posted on <a href="%1$s" rel="bookmark"><time class="entry-date" datetime="%2$s">%3$s</time></a><span class="byline"> by <span class="author vcard"><a class="url fn n" href="%4$s" title="%5$s" rel="author">%6$s</a></span></span>', 'flint' ),
    esc_url( get_permalink() ),
    esc_attr( get_the_date( 'c' ) ),
    $postdate,
    esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
    esc_attr( sprintf( __( 'View all posts by %s', 'flint' ), get_the_author() ) ),
    get_the_author()
  );
}
endif;
add_action( 'flint_entry_meta_above_post', 'flint_posted_on' );

if ( ! function_exists( 'flint_posted_in' ) ) :
/**
 * Prints HTML with the categories and tags that the post is in.
 *
 * @since 1.1.1
 */
function flint_posted_in() {
  $categories = get_the_category();
  $tags = get_the_tags();
  $separator = ' '; ?>

  <?php if ( flint_has_category() ) { ?>

    <span class="cat-links">

      <?php $output = '';
      foreach ( $categories as $category ) {
        if ( $category->cat_name != 'Uncategorized' ) {
          $output .= '<a class="label label-default" href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( 'View all posts in %s', 'flint' ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
        }
      }
      $output = trim( $output, $separator );
      echo 'Posted in ' . $output; ?>
    </span><!-- .cat-links -->

    <?php } //endif flint_has_category()

  if ( has_tag() ) {

    if ( flint_has_category() ) { ?><span class="sep"> | </span><?php } ?>

    <span class="tags-links">
      Tagged
      <?php $output = '';
      foreach ( $tags as $tag ) {$output .= '<a class="label label-info" href="'.get_tag_link( $tag->term_id ).'" title="' . esc_attr( sprintf( __( 'View all posts in %s', 'flint' ), $tag->name ) ) . '">'.$tag->name.'</a>'.$separator; }
      echo trim( $output, $separator ); ?>
    </span><!-- .tags-links --><?php

  } //endif has_tag()
}
endif;
add_action( 'flint_entry_meta_below_post', 'flint_posted_in', 10 );

/**
 * Returns true if a blog has more than 1 category
 *
 * @since 1.0.1
 */
function flint_categorized_blog() {
  if ( false == ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {

    // Create an array of all the categories that are attached to posts.
    $all_the_cool_cats = get_categories( array( 'hide_empty' => 1 ) );

    // Count the number of categories that are attached to the posts.
    $all_the_cool_cats = count( $all_the_cool_cats );

    set_transient( 'all_the_cool_cats', $all_the_cool_cats );
  }

  if ( '1' != $all_the_cool_cats ) {
    return true; // This blog has more than 1 category.
  } else {
    return false; // This blog has only 1 category.
  }
}

/**
 * Flush out the transients used in flint_categorized_blog
 *
 * @since 1.0.1
 */
function flint_category_transient_flusher() {
  delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'flint_category_transient_flusher' );
add_action( 'save_post', 'flint_category_transient_flusher' );

/**
 * The formatted output of a list of pages, using Twitter Bootstrap pagination.
 *
 * Displays page links for paginated posts (i.e. includes the <!--nextpage-->.
 * Quicktag one or more times). This tag must be within The Loop.
 *
 * @since 1.0.1
 *
 * @param string|array $args A string or array of argument(s).
 * @return string Formatted output in HTML.
 */
function flint_link_pages( $args = '' ) {
  $defaults = array(
    'before'           => '<p>',
    'after'            => '</p>',
    'link_before'      => '',
    'link_after'       => '',
    'next_or_number'   => 'number',
    'nextpagelink'     => __( 'Next page', 'flint' ),
    'previouspagelink' => __( 'Previous page', 'flint' ),
    'pagelink'         => '%',
    'echo'             => 1,
  );

  $r = wp_parse_args( $args, $defaults );
  $r = apply_filters( 'wp_link_pages_args', $r );
  extract( $r, EXTR_SKIP );

  global $page, $numpages, $multipage, $more, $pagenow;

  $output = '';
  if ( $multipage ) {
    if ( 'number' === $next_or_number ) {
      $output .= $before;
      for ( $i = 1; $i < ($numpages + 1); $i = $i + 1 ) {
        $j = str_replace( '%',$i,$pagelink );
        $output .= ' ';
        if ( ( $i != $page ) || ( ( ! $more ) && ( 1 == $page ) ) ) {
          $output .= flint_link_page( $i );
        } else {
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
          $output .= _wp_link_page( $i );
          $output .= $link_before. $previouspagelink . $link_after . '</a>';
        }
        $i = $page + 1;
        if ( $i <= $numpages && $more ) {
          $output .= _wp_link_page( $i );
          $output .= $link_before. $nextpagelink . $link_after . '</a>';
        }
        $output .= $after;
      }
    }
  }

  if ( $echo ) {
    echo $output; }

  return $output;
}

/**
 * Helper function for flint_link_pages().
 *
 * @since 1.0.1
 *
 * @param int $i Page number.
 * @return string Link.
 */
function flint_link_page( $i ) {
  global $wp_rewrite;
  $thing = get_post();

  if ( 1 == $i ) {
    $url = get_permalink();
  } else {
    if ( '' == get_option( 'permalink_structure' ) || in_array( $thing->post_status, array( 'draft', 'pending' ) ) ) {
      $url = add_query_arg( 'page', $i, get_permalink() );
    } elseif ( 'page' === get_option( 'show_on_front' ) && get_option( 'page_on_front' ) === $thing->ID ) {
      $url = trailingslashit( get_permalink() ) . user_trailingslashit( "$wp_rewrite->pagination_base/" . $i, 'single_paged' );
    } else {
      $url = trailingslashit( get_permalink() ) . user_trailingslashit( $i, 'single_paged' );
    }
  }

  return '<li><a href="' . esc_url( $url ) . '">';
}


/**
 * Display the post content, with Twitter Bootstrap "More" button.
 *
 * @since 1.0.1
 *
 * @param string $more_link_text Optional. Content for when there is more text.
 * @param bool   $strip_teaser   Optional. Strip teaser content before the more text. Default is false.
 * @param array  $args           Optional. An array of arguments for displaying the more button.
 */
function flint_the_content( $more_link_text = 'Read more', $strip_teaser = false, $args = array() ) {

  $defaults = array(
    'more_class'  => 'btn btn-primary',
    'more_before' => '<div style="float:right;"><a href="',
    'more_after'  => '</a></div>',
  );

  $args = wp_parse_args( $args, $defaults );

  $content = flint_get_the_content( $more_link_text, $strip_teaser, $args );
  $content = apply_filters( 'the_content', $content );
  $content = str_replace( ']]>', ']]&gt;', $content );
  echo $content;
}


/**
 * Retrieve the post content, with Twitter Bootstrap "More" button.
 *
 * @since 1.0.1
 *
 * @param string $more_link_text Optional. Content for when there is more text.
 * @param bool   $strip_teaser   Optional. Strip teaser content before the more text. Default is false.
 * @param array  $args           Optional. An array of arguments for displaying the more button.
 * @return string
 */
function flint_get_the_content( $more_link_text = 'Read more', $strip_teaser = false, $args = array() ) {
  global $more, $page, $pages, $multipage, $preview;
  $thing = get_post();

  $defaults = array(
    'more_class'  => 'btn btn-primary',
    'more_before' => '<div style="float:right;"><a href="',
    'more_after'  => '</a></div>',
  );

  $args = wp_parse_args( $args, $defaults );

  if ( null === $more_link_text ) {
    $more_link_text = __( '(more...)', 'flint' );
  }

  $output = '';
  $hasTeaser = false;

  if ( post_password_required() ) {
    return get_the_password_form();
  }

  if ( $page > count( $pages ) ) {
    $count = count( $pages );
  } else {
    $count = $page;
  }

  $content = $pages[ $count -1 ];

  if ( preg_match( '/<!--more(.*?)?-->/', $content, $matches ) ) {
    $content = explode( $matches[0], $content, 2 );
    if ( ! empty( $matches[1] ) && ! empty( $more_link_text ) ) {
      $more_link_text = strip_tags( wp_kses_no_null( trim( $matches[1] ) ) );
    }

    $hasTeaser = true;
  } else {
    $content = array( $content );
  }

  if ( ( false !== strpos( $thing->post_content,'<!--noteaser-->' ) && ( ( ! $multipage ) || ( 1 == $count ) ) ) ) {
    $strip_teaser = true;
  }

  $teaser = $content[0];

  if ( $more && $strip_teaser && $hasTeaser ) {
    $teaser = '';
  }

  $output .= $teaser;

  if ( count( $content ) > 1 ) {
    if ( $more ) {
      $output .= '<span id="more-' . $thing->ID . '"></span>' . $content[1];
    } else {
      if ( ! empty( $more_link_text ) ) {
        $output .= apply_filters( 'the_content_more_link', $args['more_before'] . get_permalink() . "#more-{$thing->ID}\"" . 'class="more-link ' . $args['more_class'] . '">' . $more_link_text . $args['more_after'] );
      }

      $output = force_balance_tags( $output );
    }
  }

  if ( $preview ) {
    $output = preg_replace_callback( '/\%u([0-9A-F]{4})/', '_convert_urlencoded_to_entities', $output );
  }

  return $output;
}

/**
 * Modifies password form to use bootstrap styles
 *
 * @since 1.0.1
 */
function flint_password_form() {
    global $post;
    $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
    $o = __( 'To view this protected post, enter the password below:', 'flint' ) . '
    <form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post" class="form-inline"><input class="form-control pw ' . $label . '" name="post_password" type="password" placeholder="Password"><button class="btn btn-default" type="submit" name="Submit">Submit</button>
    </form>
    ';
    return $o;
}
add_filter( 'the_password_form', 'flint_password_form' );

/**
 * Output a complete commenting form for use within a template, using Twitter Bootstrap styles.
 *
 * @since 1.0.1
 *
 * @param array       $args An array of arguments.
 * @param int|WP_Post $thing_id Post ID or WP_Post object to generate the form for. Default current post.
 *
 * @todo Remove "Required fields are marked *"
 * @todo Fix width of inputs
 * @todo Check pattern of email address
 * @todo Check required fields before allowing submit
 * @todo Fix approved tags width
 */
function flint_comment_form( $args = array(), $thing_id = null ) {

  if ( null === $thing_id ) {
    $thing_id = get_the_ID();
  }

  $commenter = wp_get_current_commenter();
  $user = wp_get_current_user();
  $user_identity = $user->exists() ? $user->display_name : '';
  $req = get_option( 'require_name_email' );
  $aria_req = ( $req ? " aria-required='true' required" : '' );

  $fields = array(
    'author' => '<p class="comment-form-author"><input class="form-control required" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" ' . $aria_req . ' placeholder="Name*"></p>',
    'email'  => '<p class="comment-form-email"><input class="form-control" id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) . '" ' . $aria_req . ' placeholder="Email Address*"></p>',
    'url'    => '<p class="comment-form-url"><input class="form-control" id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" placeholder="Website URL" /></p>',
  );

  $required_text = sprintf( ' ' . __( 'Required fields are marked %s', 'flint' ), '<span class="required">*</span>' );

  $defaults = array(
    'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
    'comment_field'        => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment*', 'noun', 'flint' ) . '</label><textarea class="form-control" id="comment" name="comment" cols="45" rows="8" aria-required="true" required></textarea></p>',
    'must_log_in'          => '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'flint' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $thing_id ) ) ) ) . '</p>',
    'logged_in_as'         => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'flint' ), get_edit_user_link(), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $thing_id ) ) ) ) . '</p>',
    'comment_notes_before' => '<p class="comment-notes">' . __( 'Your email address will not be published.', 'flint' ) . ( $req ? $required_text : '' ) . '</p>',
    'comment_notes_after'  => '<p class="form-allowed-tags">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s', 'flint' ), ' <code style="white-space:normal;">' . allowed_tags() . '</code>' ) . '</p>',
    'id_form'              => 'commentform',
    'id_submit'            => 'submit',
    'title_reply'          => __( 'Leave a Reply', 'flint' ),
    'title_reply_to'       => __( 'Leave a Reply to %s', 'flint' ),
    'cancel_reply_link'    => __( 'Cancel reply', 'flint' ),
    'label_submit'         => __( 'Post Comment', 'flint' ),
  );

  $args = wp_parse_args( $args, apply_filters( 'comment_form_defaults', $defaults ) );

  if ( comments_open( $thing_id ) ) :
    do_action( 'comment_form_before' ); ?>
    <div id="respond">
    <h3 id="reply-title"><?php comment_form_title( $args['title_reply'], $args['title_reply_to'] ); ?> <small><?php cancel_comment_reply_link( $args['cancel_reply_link'] ); ?></small></h3>

    <?php if ( get_option( 'comment_registration' ) && ! is_user_logged_in() ) :
      echo $args['must_log_in'];
      do_action( 'comment_form_must_log_in_after' );
    else : ?>
      <form class="form-horizontal" action="<?php echo site_url( '/wp-comments-post.php' ); ?>" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>">
      <?php do_action( 'comment_form_top' );
      if ( current_user_can( 'moderate_comments' ) ) :
        echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity );
        do_action( 'comment_form_logged_in_after', $commenter, $user_identity );
      else :
        echo $args['comment_notes_before'];
        do_action( 'comment_form_before_fields' );
        foreach ( (array) $args['fields'] as $name => $field ) {
        echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";
        }
        do_action( 'comment_form_after_fields' );
      endif;

      echo apply_filters( 'comment_form_field_comment', $args['comment_field'] );
      echo $args['comment_notes_after']; ?>
      <p class="form-submit">
      <button class="btn btn-default" name="submit" type="submit" id="<?php echo esc_attr( $args['id_submit'] ); ?>"><?php echo esc_html( $args['label_submit'] ); ?></button>
      <?php comment_id_fields( $thing_id ); ?>
      </p>
      <?php do_action( 'comment_form', $thing_id ); ?>
      </form>
    <?php endif; ?>

    </div><!-- #respond -->
    <?php do_action( 'comment_form_after' );
  else :
    do_action( 'comment_form_comments_closed' );
  endif;
}

/**
 * Retrieve HTML content for reply to comment link.
 *
 * @since 1.4.0
 * @see WordPress 4.3.1 get_comment_reply_link()
 *
 * @param array       $args     Comment reply link arguments. See {@see get_comment_reply_link()}
 *                              for more information on accepted arguments.
 * @param int         $_comment Comment being replied to. Default current comment.
 * @param int|WP_Post $thing    Post ID or WP_Post object the comment is going to be displayed on.
 *                              Default current post.
 * @return void|false|string Link to show comment form, if successful. False, if comments are closed.
 */
function flint_get_comment_reply_link( $args = array(), $_comment = null, $thing = null ) {
	$defaults = array(
		'add_below'     => 'comment',
		'respond_id'    => 'respond',
		'reply_text'    => __( 'Reply', 'flint' ),
		'reply_to_text' => __( 'Reply to %s', 'flint' ),
		'login_text'    => __( 'Log in to Reply', 'flint' ),
		'depth'         => 0,
		'before'        => '',
		'after'         => '',
	);

	$args = wp_parse_args( $args, $defaults );

	if ( 0 == $args['depth'] || $args['max_depth'] <= $args['depth'] ) {
		return;
	}

	$_comment = get_comment( $_comment );

	if ( empty( $thing ) ) {
		$thing = $_comment->comment_post_ID;
	}

	$thing = get_post( $thing );

	if ( ! comments_open( $thing->ID ) ) {
		return false;
	}

	/**
	 * Filter the comment reply link arguments.
	 *
	 * @param array   $args     Comment reply link arguments. See {@see get_comment_reply_link()}
	 *                          for more information on accepted arguments.
	 * @param object  $_comment The object of the comment being replied to.
	 * @param WP_Post $thing    The {@see WP_Post} object.
	 */
	$args = apply_filters( 'comment_reply_link_args', $args, $_comment, $thing );

	if ( get_option( 'comment_registration' ) && ! is_user_logged_in() ) {
		$link = sprintf( '<a rel="nofollow" class="comment-reply-login" href="%s">%s</a>',
			esc_url( wp_login_url( get_permalink() ) ),
			$args['login_text']
		);
	} else {
		$onclick = sprintf( 'return addComment.moveForm( "%1$s-%2$s", "%2$s", "%3$s", "%4$s" )',
			$args['add_below'], $_comment->comment_ID, $args['respond_id'], $thing->ID
		);

		$link = sprintf( "<a rel='nofollow' class='comment-reply-link btn btn-primary btn-sm' href='%s' onclick='%s' aria-label='%s'>%s</a>",
			esc_url( add_query_arg( 'replytocom', $_comment->comment_ID, get_permalink( $thing->ID ) ) ) . '#' . $args['respond_id'],
			$onclick,
			esc_attr( sprintf( $args['reply_to_text'], $_comment->comment_author ) ),
			$args['reply_text']
		);
	}
	/**
	 * Filter the comment reply link.
	 *
	 * @param string  $link     The HTML markup for the comment reply link.
	 * @param array   $args     An array of arguments overriding the defaults.
	 * @param object  $_comment The object of the comment being replied.
	 * @param WP_Post $thing    The WP_Post object.
	 */
	return apply_filters( 'comment_reply_link', $args['before'] . $link . $args['after'], $args, $_comment, $thing );
}

/**
 * Displays the HTML content for reply to comment link.
 *
 * @since 1.4.0
 * @see WordPress 4.3.1 comment_reply_link()
 * @see flint_get_comment_reply_link()
 *
 * @param array       $args     Optional. Override default options.
 * @param int         $_comment Comment being replied to. Default current comment.
 * @param int|WP_Post $thing    Post ID or WP_Post object the comment is going to be displayed on.
 *                              Default current post.
 */
function flint_comment_reply_link( $args = array(), $_comment = null, $thing = null ) {
	echo flint_get_comment_reply_link( $args, $_comment, $thing );
}

/**
 * Load sidebar template.
 *
 * Modeled after get_template_part and get_sidebar
 * get_sidebar doesn't make sense for all widget areas, so this replaces that function
 *
 * @since 1.4.0
 *
 * @param string $slug    The slug of the specialised sidebar.
 * @param bool   $minimal If true, using the Minimal page template.
 */
function flint_get_sidebar( $slug, $minimal = false ) {
  $options = flint_options();

  switch ( $minimal ) {
    case true:
      if ( $slug === $options['minimal_widget_area'] ) { flint_get_sidebar( $slug, false ); }
      break;
    case false:
      do_action( 'get_sidebar', $slug );

      $templates   = array();
      $templates[] = "widgets/area-{$slug}.php";

      locate_template( $templates, true, false );
      break;
  }
}

/**
 * Whether a sidebar is in use on the Minimal page template
 *
 * @since 1.4.0
 * @see is_active_sidebar() for other page templates
 *
 * @param string $slug Sidebar name, id or number to check.
 *
 * @return bool true if the sidebar is in use, false otherwise.
 */
function flint_is_active_sidebar( $slug ) {
  $options = flint_options();

  if ( $slug === $options['minimal_widget_area'] && is_active_sidebar( $slug ) ) :
    return true;
  else :
    return false;
  endif;
}

/**
 * Returns current theme version.
 *
 * @since 1.1.0
 */
function flint_theme_version() {
  $theme = wp_get_theme();
  return $theme->Version;
}

/**
 * Returns breadcrumbs for pages
 *
 * @since 1.1.0
 *
 * @param string $template The page template.
 */
function flint_breadcrumbs( $template = 'default' ) {
  $options = flint_options();

  switch ( $template ) {
    case 'clear':
      if ( 'breadcrumbs' === $options['clear_nav'] ) { flint_breadcrumbs(); }
      break;
    case 'minimal':
      if ( 'breadcrumbs' === $options['minimal_nav'] ) { flint_breadcrumbs(); }
      break;
    default:
      global $post;
      $anc = get_post_ancestors( $post->ID );
      $anc = array_reverse( $anc );
      echo '<ol class="breadcrumb">';
      echo '<li><a href="' . get_home_url() . '">Home</a></li>';
      foreach ( $anc as $ancestor ) { echo '<li><a href="' . get_permalink( $ancestor ) . '">' . get_the_title( $ancestor ) . '</a></li>'; }
      echo '<li class="active">' . get_the_title() . '</li>';
      echo '</ol>';
      break;
  }
}

/**
 * Creates custom footer from theme options
 *
 * @since 1.1.0
 */
function flint_custom_footer() {
  $options = flint_options();

  $footer = stripslashes( $options['footer_content'] );

  $patterns = array(
    '/{site title}/',
    '/{site description}/',
    '/{year}/',
    '/{company}/',
    '/{phone}/',
    '/{email}/',
    '/{fax}/',
    '/{address}/',
  );
  $replacements = array(
    get_bloginfo( 'name' ),
    get_bloginfo( 'description' ),
    date( 'Y' ),
    '<span itemprop="name">'      . $options['org'] . '</span>',
    '<span itemprop="telephone">' . $options['org_tel']     . '</span>',
    '<span itemprop="email">'     . $options['org_email']   . '</span>',
    '<span itemprop="faxNumber">' . $options['org_fax']     . '</span>',
    '<span id="address" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress"><span id="street" itemprop="streetAddress">' . $options['org_address'] . '</span><span class="comma">, </span><span id="locality" itemprop="addressLocality">' . $options['org_locality'] . '</span> <span id="postal-code" itemprop="postalCode">' . $options['org_postal_code'] . '</span></span>',
  );

  $footer = preg_replace( $patterns, $replacements, $footer );
  echo '<div id="org" itemscope itemtype="http://schema.org/Organization">';
  echo $footer;
  echo '</div>';
}

/**
 * Generate CSS from customization options
 *
 * @since 1.1.0
 */
function flint_options_css() {
  $options = flint_options();
  $colors = flint_options_colors();

  $body = 'body {';
  $body .= 'background-color: #' . $colors['body_bg'] . '; font-family: ';

  switch ( $options['font_family_base'] ) {
    case 'Open Sans':
      $body .= '"Open Sans",         sans-serif; font-weight: 300; }';
      break;
    case 'Oswald':
      $body .= '"Oswald",            sans-serif; font-weight: 300; }';
      break;
    case 'Roboto':
      $body .= '"Roboto",            sans-serif; font-weight: 300; }';
      break;
    case 'Droid Sans':
      $body .= '"Droid Sans",        sans-serif; font-weight: 400; }';
      break;
    case 'Lato':
      $body .= '"Lato",              sans-serif; font-weight: 300; }';
      break;
    case 'Nova Square':
      $body .= '"Nova Square",       sans-serif; font-weight: 400; }';
      break;
    case 'Strait':
      $body .= '"Strait",            sans-serif; font-weight: 400; }';
      break;
    case 'Yanone Kaffeesatz':
      $body .= '"Yanone Kaffeesatz", sans-serif; font-weight: 300; }';
      break;
  }

  $headings = 'h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, .navbar-brand { font-family: ';

  switch ( $options['headings_font_family'] ) {
    case 'Open Sans':
      $headings .= '"Open Sans",         sans-serif; font-weight: 400;}';
      break;
    case 'Oswald':
      $headings .= '"Oswald",            sans-serif; font-weight: 400;}';
      break;
    case 'Roboto':
      $headings .= '"Roboto",            sans-serif; font-weight: 400;}';
      break;
    case 'Droid Sans':
      $headings .= '"Droid Sans",        sans-serif; font-weight: 400;}';
      break;
    case 'Lato':
      $headings .= '"Lato",              sans-serif; font-weight: 400;}';
      break;
    case 'Nova Square':
      $headings .= '"Nova Square",       sans-serif; font-weight: 400; }';
      break;
    case 'Strait':
      $headings .= '"Strait",            sans-serif; font-weight: 400;}';
      break;
    case 'Yanone Kaffeesatz':
      $headings .= '"Yanone Kaffeesatz", sans-serif; font-weight: 400;}';
      break;
  }
  echo '<style type="text/css">';
  echo $body;
  echo $headings;
  echo 'a {color:' . $colors['link_color'] . ';}';
  echo 'a:hover, a:focus {color:' . $colors['link_hover_color'] . ';}';
  echo 'blockquote {border-left-color: ' . $colors['blockquote_border_color'] . ';}';
  echo '.fill { background-color: ' . $colors['fill'] . '; border-color: ' . $colors['fill_darker'] . '; color: ' . $colors['fill_color'] . '; }';
  echo '.navbar-inverse .navbar-nav > li > a, .fill a, .fill-light a { color: ' . $colors['fill_link_color'] . '; }';
  echo '.fill a:hover, .fill-light a:hover { color: ' . $colors['fill_color'] . '; }';
  echo '.site-branding a, .site-branding a:hover { color: ' . $colors['fill_color'] . '; }';
  echo '.navbar-inverse .navbar-nav > .dropdown > a .caret { border-top-color: ' . $colors['fill_link_color'] . '; border-bottom-color: ' . $colors['fill_link_color'] . '; }';
  echo '.navbar-inverse .navbar-nav > .open > a, .navbar-inverse .navbar-nav > .open > a:hover, .navbar-inverse .navbar-nav > .open > a:focus, .navbar-inverse .navbar-nav > li > a:hover, .navbar-inverse .navbar-nav > .active > a, .navbar-inverse .navbar-nav > .active > a:hover, .navbar-inverse .navbar-nav > .active > a:focus { color: ' . $colors['fill_color'] . '; background-color: ' . $colors['fill_darker'] . ';
}';
  echo '.navbar-brand { color: ' . $colors['fill_color'] . '!important; }';
  echo '.fill-light { background: ' . $colors['fill_light'] . '; color: ' . $colors['fill_color'] . '; }';
  echo '</style>';
}

/**
 * Retrieve the classes for the body element as an array.
 *
 * Body class is determined by page template
 *
 * @since 1.1.0
 * @see WordPress body_class()
 *
 * @uses body_class()
 */
function flint_body_class() {
  global $post;
  $options = flint_options();
  if ( ! empty( $post->ID ) ) {
    $template = get_post_meta( $post->ID, '_wp_page_template', true );

    if ( 'templates/clear.php' === $template ) {
      switch ( $options['clear_nav'] ) {
        case 'navbar':
          body_class( 'clear clear-nav' );
          break;
        case 'breadcrumbs':
          body_class( 'clear clear-breadcrumbs' );
          break;
      }
    } elseif ( 'templates/minimal.php' === $template ) {
      switch ( $options['minimal_nav'] ) {
        case 'navbar':
          body_class( 'clear clear-nav' );
          break;
        case 'breadcrumbs':
          body_class( 'clear clear-breadcrumbs' );
          break;
      }
    } else {
      body_class();
    }
  } else {
    body_class();
  }
}

/**
 * Display featured image for a post according to theme options
 *
 * @since 1.3.0
 *
 * @param string $size Optional. Registered image size to use. Default 'post-thumbnail'.
 * @param string $attr Optional. Query string or array of attributes. Default empty.
 */
function flint_the_post_thumbnail( $size = 'post-thumbnail', $attr = '' ) {
  echo flint_get_the_post_thumbnail( $size, $attr );
}

/**
 * Retrieve featured image for a post according to theme options
 *
 * @since 1.5.0
 *
 * @param string $size Optional. Registered image size to use. Default 'post-thumbnail'.
 * @param string $attr Optional. Query string or array of attributes. Default empty.
 */
function flint_get_the_post_thumbnail( $size = 'post-thumbnail', $attr = '' ) {
  $options = flint_options();
  $type    = get_post_type();

  switch ( $type ) {
    case 'post':
      if ( 'never' !== $options['post_featured_image'] ) {
        if ( 'archives' !== $options['post_featured_image'] || is_archive() ) {
          if ( has_post_thumbnail() ) {
            return get_the_post_thumbnail( null, $size, $attr );
          }
        }
      }
      break;

    case 'page':
      if ( 'never' !== $options['page_featured_image'] ) {
        if ( 'archives' !== $options['page_featured_image'] || is_archive() ) {
          if ( has_post_thumbnail() ) {
            return get_the_post_thumbnail( null, $size, $attr );
          }
        }
      }
      break;

    default:
      if ( has_post_thumbnail() ) {
        return get_the_post_thumbnail( null, $size, $attr );
      }
      break;
  }
}

/**
 * Check if the current post has any of given category
 *
 * Also checks for any non-Uncategorized category if no category specified.
 *
 * @since 1.1.1
 * @see has_category()
 *
 * @param string|int|array $category Optional. The category name/term_id/slug or array of them to check for.
 * @param int|object       $thing    Optional. Post to check instead of the current post.
 *
 * @return bool True if the current post has any of the given categories (or any category, if no category specified).
 */
function flint_has_category( $category = '', $thing = null ) {
  global $post;
  if ( ! $thing ) {
    $thing = $post;
  }

  if ( has_term( $category, 'category', $thing ) ) {
    $cats = '';

    foreach ( get_the_category() as $cat ) {
      if ( $cat->cat_name != 'Uncategorized' ) {
        $cats .= $cat->cat_name;
      }
    }

    $output = trim( $cats, ' ' );

    if ( ! empty( $output ) ) {
      return true;
    } else {
      return false;
    }
  } else {
    return false;
  }
}

/**
 * Content class
 *
 * Retrieve and display the classes for the content div.
 * Checks if side widget areas are active and changes
 * width of content accordingly.
 *
 * @since 1.3.0
 *
 * @uses flint_options()
 * @uses is_active_sidebar()
 *
 * @param string $class   Additional class or classes to append to content div.
 * @var   array  $options The options array
 *
 * @todo Allow array input for $class
 */
function flint_content_class( $class = '' ) {
  global $post;
  $options = flint_options();

  $class .= ! empty( $class ) ? ' site-content col-xs-12' : 'site-content col-xs-12';

  if ( is_active_sidebar( 'left' ) || is_active_sidebar( 'right' ) ) {
    if ( is_active_sidebar( 'left' ) && is_active_sidebar( 'right' ) ) {
      $class .= ' col-md-6 wa-both';
    } else {
      if ( is_active_sidebar( 'left' ) ) {
        $class .= ' col-md-9 wa-left';
      } elseif ( is_active_sidebar( 'right' ) ) {
        $class .= ' col-md-9 wa-right';
      }
    }
  }

  echo 'class="' . $class . '"';
}

/**
 * Post class
 *
 * Retrieves and displays the classes for the post div.
 *
 * @since 1.3.0
 *
 * @uses flint_post_width_class()
 * @uses post_class()
 *
 * @todo Add parameter to append additional classes that accepts both string and array input
 */
function flint_post_class() {
  post_class( flint_post_width_class() );
}

/**
 * Navigation fallback
 *
 * If the menu doesn't exist, display search instead.
 *
 * @since 1.3.0
 */
function flint_nav_fallback() {
  ?>
  <form method="get" class="navbar-form navbar-right" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
    <div class="form-group">
      <input type="text" class="form-control" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="Search" style="width: 200px;">
    </div>
  </form> <?php
}

/**
 * Retrieves post width
 *
 * @since 1.5.0
 */
function flint_post_width() {
  $options = flint_options();
  $type = get_post_type( get_the_ID() );

  if ( ! is_active_sidebar( 'left' ) && ! is_active_sidebar( 'right' ) ) {
    if ( 'page' === $type ) {
      $template = get_post_meta( get_the_ID(), '_wp_page_template', true );

      switch ( $template ) {
        case 'templates/clear.php':
          $post_width = $options['clear_width'];
          break;

        case 'templates/minimal.php':
          $post_width = $options['minimal_width'];
          break;

        case 'templates/slim.php':
          $post_width = 'slim';
          break;

        case 'templates/narrow.php':
          $post_width = 'narrow';
          break;

        case 'templates/full.php':
          $post_width = 'full';
          break;

        case 'templates/wide.php':
          $post_width = 'wide';
          break;

        default:
          $post_width = $options['page_default_width'];
      }
    } elseif ( 'page' === $type ) {
      $format = get_post_format( $post->ID );

      switch ( $format ) {
        case 'aside':
          $post_width = 'wide';
          break;

        case 'link':
          $post_width = 'wide';
          break;

        case 'status':
          $post_width = 'wide';
          break;

        default:
          $post_width = $options['post_default_width'];
          break;
      }
    } else {
      $post_width = $options['post_default_width'];
    }
  } else {
    $post_width = 'wide';
  }

  return $post_width;
}

/**
 * Retrieves class to achieve post width
 *
 * @since 1.5.0
 */
function flint_post_width_class() {
  $post_width = flint_post_width();

  switch ( $post_width ) {
    case 'slim':
      return 'col-xs-12 col-sm-8 col-md-4';
      break;

    case 'narrow':
      return 'col-xs-12 col-sm-8 col-md-6';
      break;

    case 'full':
      return 'col-xs-12 col-sm-10 col-md-8';
      break;

    case 'wide':
      return 'col-xs-12';
      break;
  }
}

/**
 * Retrieves margin for post, and post thumbnail if needed
 *
 * @since 1.5.0
 *
 * @param bool $thumbnail Optional. Whether to display the post thumbnail in margin. Default false.
 */
function flint_post_margin( $thumbnail = false ) {
  $post_width = flint_post_width();
  $format = get_post_format();
  $output     = '';

  if ( true === $thumbnail && ! is_active_sidebar( 'left' ) && ! is_active_sidebar( 'right' ) ) {
    switch ( $post_width ) {
      case 'slim':
        $output .= '<div class="hidden-xs hidden-sm col-md-2"></div>';
        $output .= '<div class="col-xs-12 col-sm-2 col-md-2">';
        $output .= flint_get_the_post_thumbnail();
        if ( ! is_single() && 'gallery' === $format ) {
          $output .= '<a class="btn btn-info btn-block hidden-xs" href="' . get_permalink() . '">View gallery</a>';
        }
        $output .= '</div>';
        break;

      case 'narrow':
        $output .= '<div class="hidden-xs hidden-sm col-md-1"></div>';
        $output .= '<div class="col-xs-12 col-sm-2 col-md-2">';
        $output .= flint_get_the_post_thumbnail();
        if ( ! is_single() && 'gallery' === $format ) {
          $output .= '<a class="btn btn-info btn-block hidden-xs" href="' . get_permalink() . '">View gallery</a>';
        }
        $output .= '</div>';
        break;

      case 'wide':
        $output .= '<div class="col-xs-12 col-sm-12 hidden-md hidden-lg">';
        $output .= flint_get_the_post_thumbnail();
        if ( ! is_single() && 'gallery' === $format ) {
          $output .= '<a class="btn btn-info btn-block hidden-xs" href="' . get_permalink() . '">View gallery</a>';
        }
        $output .= '</div>';
        break;

      default:
        $output .= '<div class="col-xs-12 col-sm-2 col-md-2">';
        $output .= flint_get_the_post_thumbnail();
        if ( ! is_single() && 'gallery' === $format ) {
          $output .= '<a class="btn btn-info btn-block hidden-xs" href="' . get_permalink() . '">View gallery</a>';
        }
        $output .= '</div>';
        break;
    }

    return $output;
  } else {
    switch ( $post_width ) {
      case 'slim':
        return '<div class="hidden-xs col-sm-2 col-md-4"></div>';
        break;

      case 'narrow':
        return '<div class="hidden-xs col-sm-2 col-md-3"></div>';
        break;

      case 'wide':
        break;

      default:
        return '<div class="hidden-xs col-sm-1 col-md-2"></div>';
        break;
    }
  }
}

/**
 * Display edit comment link with formatting.
 *
 * @since 1.5.0
 * @see WordPress 4.3.1 edit_comment_link()
 *
 * @global object $comment
 *
 * @param string $text   Optional. Anchor text.
 * @param string $before Optional. Display before edit link.
 * @param string $after  Optional. Display after edit link.
 */
function flint_edit_comment_link( $text = null, $before = '', $after = '' ) {
	global $comment;

	if ( ! current_user_can( 'edit_comment', $comment->comment_ID ) ) {
		return;
	}

	if ( null === $text ) {
		$text = __( 'Edit This', 'flint' );
	}

	$link = '<a class="comment-edit-link btn btn-default btn-sm" href="' . get_edit_comment_link( $comment->comment_ID ) . '">' . $text . '</a>';

	/**
	 * Filter the comment edit link anchor tag.
	 *
	 * @param string $link       Anchor tag for the edit link.
	 * @param int    $comment_id Comment ID.
	 * @param string $text       Anchor text.
	 */
	echo $before . apply_filters( 'edit_comment_link', $link, $comment->comment_ID, $text ) . $after;
}
