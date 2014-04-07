<?php
/**
 * Custom template tags for this theme.
 *
 * @package Flint
 * @since 1.2.1
 */

if ( ! function_exists( 'flint_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 */
function flint_content_nav( $nav_id ) {
  global $wp_query;
  global $post;
  global $post_id;
  $type = get_post_type($post_id);

  if ( is_single() ) {
    $previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
    $next = get_adjacent_post( false, '', false );

    if ( ! $next && ! $previous )
      return;
    if ( $type = 'steel_product' )//Hide bottom navigation for products
      return;
  }

  if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
    return;

  $nav_class = ( is_single() ) ? 'navigation-post' : 'navigation-paging';

  ?>  
  <nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo $nav_class; ?>">
    <h1 class="screen-reader-text"><?php _e( 'Post navigation', 'flint' ); ?></h1>

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
    <article id="comment-<?php comment_ID(); ?>" class="comment media row">
      <div class="col-lg-2 col-md-2 col-sm-2">
        <?php echo flint_avatar( $comment ); ?>
      </div>
      <div class="media-body col-lg-7 col-md-7 col-sm-7">
        <h4 class="media-heading"><?php printf( __( '%s <span class="says">says:</span>', 'flint' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?></h4>
        <?php if ( $comment->comment_approved == '0' ) : ?>
        <em><?php _e( 'Your comment is awaiting moderation.', 'flint' ); ?></em>
        <br>
        <?php endif; ?>
        <?php comment_text(); ?>
        
      </div>
      <div class="col-lg-3 col-md-3 col-sm-3">
        <p><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time datetime="<?php comment_time( 'c' ); ?>">
        <?php printf( _x( '%1$s <br> %2$s', '1: date, 2: time', 'flint' ), get_comment_date('M j, Y'), get_comment_time('g:i a') ); ?>
        </time></a></p>
        <?php flint_reply_link(array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) )); ?>
        <?php if ( current_user_can('moderate_comments') ) { ?><a class="btn btn-default btn-sm" href="<?php echo get_edit_comment_link(); ?>" >Edit</a><?php } ?>
      </div>
    </article>
    
  <?php
    break;
  endswitch;
}
endif; // flint_comment()


add_action('flint_entry_meta_below_post','flint_the_comments', 20);
function flint_the_comments() {
  if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
    <span class="sep"> | </span>
    <span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'flint' ), __( '1 Comment', 'flint' ), __( '% Comments', 'flint' ) ); ?></span>
  <?php endif;
}


add_action('flint_entry_meta_above_post','flint_posted_on');
if ( ! function_exists( 'flint_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function flint_posted_on() {
  if (get_the_date('Y') != date('Y')) :
    $postdate = esc_html( get_the_date('F j, Y') );
  else :
    $postdate = esc_html( get_the_date('F j') );
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


add_action('flint_entry_meta_below_post','flint_posted_in', 10);
if ( ! function_exists( 'flint_posted_in' ) ) :
/**
 * Prints HTML with the categories and tags that the post is in.
 */
function flint_posted_in() {
  $categories = get_the_category();
  $tags = get_the_tags();
  $separator = ' '; ?>
  
  <?php if (flint_has_category()) { ?>
  
    <span class="cat-links">
      
      <?php $output = '';
      foreach($categories as $category) {
        if ($category->cat_name != 'Uncategorized') {
          $output .= '<a class="label label-default" href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( 'View all posts in %s', 'flint' ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
        }
      }
      $output = trim($output, $separator);
      echo 'Posted in ' . $output; ?>
    </span><!-- .cat-links -->
    
    <?php } //endif flint_has_category()
  
  if (has_tag()) {
    
    if (flint_has_category()) { ?><span class="sep"> | </span><?php } ?>
  
    <span class="tags-links">
      Tagged
      <?php $output = '';
      foreach($tags as $tag) {$output .= '<a class="label label-info" href="'.get_tag_link( $tag->term_id ).'" title="' . esc_attr( sprintf( __( 'View all posts in %s', 'flint' ), $tag->name ) ) . '">'.$tag->name.'</a>'.$separator; }
      echo trim($output, $separator); ?>
    </span><!-- .tags-links --><?php
    
  } //endif has_tag()
}
endif;


/**
 * Returns true if a blog has more than 1 category
 */
function flint_categorized_blog() {
  if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
    
    $all_the_cool_cats = get_categories( array( 'hide_empty' => 1, ) );// Create an array of all the categories that are attached to posts

    
    $all_the_cool_cats = count( $all_the_cool_cats );// Count the number of categories that are attached to the posts

    set_transient( 'all_the_cool_cats', $all_the_cool_cats );
  }

  if ( '1' != $all_the_cool_cats ) {
    return true;// This blog has more than 1 category
  } else {
    return false;// This blog has only 1 category
  }
}

/**
 * Flush out the transients used in flint_categorized_blog
 */
function flint_category_transient_flusher() {
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
    'next_or_number' => 'number', 'nextpagelink' => __('Next page', 'flint'),
    'previouspagelink' => __('Previous page', 'flint'), 'pagelink' => '%',
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
function flint_the_content($more_link_text = 'Read more', $stripteaser = false, $args = array() ) {
  
  $defaults = array(
    'more_class'  => 'btn btn-primary',
    'more_before' => '<div style="float:right;"><a href="',
    'more_after'  => '</a></div>',
  );
  
  $args = wp_parse_args( $args, $defaults );
  
  $content = flint_get_the_content($more_link_text, $stripteaser, $args);
  $content = apply_filters('the_content', $content);
  $content = str_replace(']]>', ']]&gt;', $content);
  echo $content;
}


/**
 * Modifies get_the_content to allow for more tag to be a bootstrap button
 */
function flint_get_the_content( $more_link_text = 'Read more', $stripteaser = false, $args = array() ) {
  global $more, $page, $pages, $multipage, $preview;

  $post = get_post();
  
  $defaults = array(
    'more_class'  => 'btn btn-primary',
    'more_before' => '<div style="float:right;"><a href="',
    'more_after'  => '</a></div>',
  );
  
  $args = wp_parse_args( $args, $defaults );

  if ( null === $more_link_text )
    $more_link_text = __( '(more...)', 'flint' );

  $output = '';
  $hasTeaser = false;

  if ( post_password_required() )
    return get_the_password_form();

  if ( $page > count($pages) )
    $page = count($pages);

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
        $output .= apply_filters( 'the_content_more_link', $args['more_before'] . get_permalink() . "#more-{$post->ID}\"" . 'class="more-link ' . $args['more_class'] . '">' . $more_link_text . $args['more_after'] );
      $output = force_balance_tags($output);
    }

  }
  if ( $preview )
    $output =  preg_replace_callback('/\%u([0-9A-F]{4})/', '_convert_urlencoded_to_entities', $output);

  return $output;
}


/**
 * Modifies password form to use bootstrap styles
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
                '<input class="form-control required" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" ' . $aria_req . ' placeholder="Name*"></p>',
    'email'  => '<p class="comment-form-email">' .
                '<input class="form-control" id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" ' . $aria_req . ' placeholder="Email Address*"></p>',
    'url'    => '<p class="comment-form-url">' .
                '<input class="form-control" id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" placeholder="Website URL" /></p>',
  );

  $required_text = sprintf( ' ' . __('Required fields are marked %s', 'flint'), '<span class="required">*</span>' );
  $defaults = array(
    'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
    'comment_field'        => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment*', 'noun', 'flint' ) . '</label><textarea class="form-control" id="comment" name="comment" cols="45" rows="8" aria-required="true" required></textarea></p>',
    'must_log_in'          => '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
    'logged_in_as'         => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ), get_edit_user_link(), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
    'comment_notes_before' => '<p class="comment-notes">' . __( 'Your email address will not be published.', 'flint' ) . ( $req ? $required_text : '' ) . '</p>',
    'comment_notes_after'  => '<p class="form-allowed-tags">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s' ), ' <code style="white-space:normal;">' . allowed_tags() . '</code>' ) . '</p>',
    'id_form'              => 'commentform',
    'id_submit'            => 'submit',
    'title_reply'          => __( 'Leave a Reply', 'flint' ),
    'title_reply_to'       => __( 'Leave a Reply to %s', 'flint' ),
    'cancel_reply_link'    => __( 'Cancel reply', 'flint' ),
    'label_submit'         => __( 'Post Comment', 'flint' ),
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
        <form class="form-horizontal" action="<?php echo site_url( '/wp-comments-post.php' ); ?>" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>">
          <?php do_action( 'comment_form_top' ); ?>
          <?php if ( current_user_can('moderate_comments') ) : ?>
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
            <button class="btn btn-default" name="submit" type="submit" id="<?php echo esc_attr( $args['id_submit'] ); ?>"><?php echo esc_attr( $args['label_submit'] ); ?></button>
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
 */
function get_flint_reply_link($args = array(), $comment = null, $post = null) {
  global $user_ID;

  $defaults = array('add_below' => 'comment', 'respond_id' => 'respond', 'reply_text' => __('Reply', 'flint'),
    'login_text' => __('Log in to Reply', 'flint'), 'depth' => 0, 'before' => '', 'after' => '');

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
    $link = '<a rel="nofollow" class="comment-reply-login btn btn-primary btn-sm" href="' . esc_url( wp_login_url( get_permalink() ) ) . '">' . $login_text . '</a>';
  else
    $link = "<a class='comment-reply-link btn btn-primary btn-sm' href='" . esc_url( add_query_arg( 'replytocom', $comment->comment_ID ) ) . "#" . $respond_id . "' onclick='return addComment.moveForm(\"$add_below-$comment->comment_ID\", \"$comment->comment_ID\", \"$respond_id\", \"$post->ID\")'>$reply_text</a>";
  return apply_filters('comment_reply_link', $before . $link . $after, $args, $comment, $post);
}
/**
 * Displays the HTML content for reply to comment link.
 */
function flint_reply_link($args = array(), $comment = null, $post = null) {
  echo get_flint_reply_link($args, $comment, $post);
}

/**
 * Gets the template for the widget area
 * Modeled after get_template_part and get_sidebar
 * get_sidebar doesn't make sense for all widget areas, so this replaces that function
 *
 */
function flint_get_widgets( $slug, $minimal = false ) {
  $options = get_option( 'flint_templates' );
  $minimal_widget_area = !empty($options['minimal_widget_area']) ? $options['minimal_widget_area'] : false;
  
  switch ($minimal) {
    case true:
      if ($slug == $minimal_widget_area) { flint_get_widgets( $slug, false); }
      break;
    case false:
      do_action( "get_sidebar", $slug );
      
      $templates   = array();
      $templates[] = "widgets/area-{$slug}.php";
      
      locate_template($templates, true, false);
      break;
  }
}

/**
 * Checks to see if widget area is to be displayed for the Minimal page template.
 * For other page templates, use is_active_sidebar()
 */
function flint_is_active_widgets( $slug ) {
  $options = get_option( 'flint_templates' );
  $minimal_widget_area = !empty($options['minimal_widget_area']) ? $options['minimal_widget_area'] : false;
  
  if ($slug == $minimal_widget_area && is_active_sidebar( $slug )):
    return true;
  else:
    return false;
  endif;
}

/**
 * Returns current theme version.
 */
function flint_theme_version() {
  $theme = wp_get_theme();
  return $theme->Version;
}

/**
 * Returns breadcrumbs for pages
 */
function flint_breadcrumbs( $display = 'show' ) {
  $options = get_option( 'flint_templates' );
  $clear_nav   = !empty($options['clear_nav'])   ? $options['clear_nav']   : 'breadcrumbs';
  $minimal_nav = !empty($options['minimal_nav']) ? $options['minimal_nav'] : 'navbar';
  switch ($display) {
    case 'show':
      global $post;
      $anc = get_post_ancestors( $post->ID );
      $anc = array_reverse( $anc );
      echo '<ol class="breadcrumb">';
      echo '<li><a href="' . get_home_url() . '">Home</a></li>';
      foreach ( $anc as $ancestor ) { echo '<li><a href="' . get_permalink( $ancestor ) . '">' . get_the_title( $ancestor ) . '</a></li>'; }
      echo '<li class="active">' . get_the_title() . '</li>';
      echo '</ol>';
      break;
    case 'clear':
      
      if ($clear_nav == 'breadcrumbs') { flint_breadcrumbs(); }
      break;
    case 'minimal':
      $options = get_option( 'flint_templates' );
      if ($minimal_nav == 'breadcrumbs') { flint_breadcrumbs(); }
      break;
  }
  $options = get_option( 'flint_templates' );
}

/**
 * Creates custom footer from theme options
 */
function flint_custom_footer() {
  $options = get_option( 'flint_general' );
  
  $company     = !empty($options['company'])     ? $options['company']            : '';
  $tel         = !empty($options['tel'])         ? $options['tel']                : '';
  $email       = !empty($options['email'])       ? $options['email']              : '';
  $fax         = !empty($options['fax'])         ? $options['fax']                : '';
  $address     = !empty($options['address'])     ? $options['address']            : '';
  $locality    = !empty($options['locality'])    ? $options['locality']           : '';
  $postal_code = !empty($options['postal_code']) ? $options['postal_code']        : '';
  $footer      = !empty($options['text'])        ? stripslashes($options['text']) : '';
  
  $patterns = array(
    '/{site title}/',
    '/{site description}/',
    '/{year}/',
    '/{company}/',
    '/{phone}/',
    '/{email}/',
    '/{fax}/',
    '/{address}/'
  );
  $replacements = array(
    get_bloginfo( 'name' ),
    get_bloginfo( 'description' ),
    date('Y'),
    '<span itemprop="name">'      . $company . '</span>',
    '<span itemprop="telephone">' . $tel     . '</span>',
    '<span itemprop="email">'     . $email   . '</span>',
    '<span itemprop="faxNumber">' . $fax     . '</span>',
    '<span id="address" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress"><span id="street" itemprop="streetAddress">' . $address . '</span><span class="comma">, </span><span id="locality" itemprop="addressLocality">' . $locality . '</span> <span id="postal-code" itemprop="postalCode">' . $postal_code . '</span></span>'
  );
  
  $footer = preg_replace( $patterns, $replacements, $footer);
  echo '<div id="org" itemscope itemtype="http://schema.org/Organization">';
  echo $footer;
  echo '</div>';
}

function flint_options_css() {
  $fonts = get_option( 'flint_fonts' );
  $body_font    = !empty($fonts['body_font'])    ? $fonts['body_font']    : 'Open Sans' ;
  $heading_font = !empty($fonts['heading_font']) ? $fonts['heading_font'] : 'Open Sans' ;

  $colors = get_option( 'flint_colors' );
  $link         = !empty($colors['link'])        ? $colors['link']               : '#428bca' ;
  $link_hover   = !empty($colors['link'])        ? flint_darken_hex($link,15)    : '#2a6496' ;
  $canvas       = !empty($colors['canvas'])      ? $colors['canvas']             : '#222222' ;
  $canvas_dark  = !empty($colors['canvas'])      ? flint_darken_hex($canvas,10)  : '#000000' ;
  $canvas_light = !empty($colors['canvas'])      ? flint_lighten_hex($canvas,5)  : '#333333' ;
  $canvas_text  = !empty($colors['canvas_text']) ? $colors['canvas_text']        : '#ffffff' ;

  $bg         = get_theme_mod( 'background_color', '#eeeeee' );
  $blockquote = flint_darken_hex($bg,6.5);

  $canvas_link = flint_darken_hex($canvas_text,15);

  $body = 'body {';
  $body .= 'background-color: ' . $bg . '; font-family: ';

  switch ($body_font) {
    case 'Open Sans':
      $body .= '"Open Sans",  sans-serif; font-weight: 300; }';
      break;
    case 'Oswald':
      $body .= '"Oswald",     sans-serif; font-weight: 300; }';
      break;
    case 'Roboto':
      $body .= '"Roboto",     sans-serif; font-weight: 300; }';
      break;
    case 'Droid Sans':
      $body .= '"Droid Sans", sans-serif; font-weight: 400; }';
      break;
    case 'Lato':
      $body .= '"Lato",       sans-serif; font-weight: 300; }';
      break;
    case 'Strait':
      $body .= '"Strait",     sans-serif; font-weight: 400; }';
      break;
  }

  $headings = 'h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 { font-family: ';

  switch ($heading_font) {
    case 'Open Sans':
      $headings .= '"Open Sans",  sans-serif; font-weight: 400;}';
      break;
    case 'Oswald':
      $headings .= '"Oswald",     sans-serif; font-weight: 400;}';
      break;
    case 'Roboto':
      $headings .= '"Roboto",     sans-serif; font-weight: 400;}';
      break;
    case 'Droid Sans':
      $headings .= '"Droid Sans", sans-serif; font-weight: 400;}';
      break;
    case 'Lato':
      $headings .= '"Lato",       sans-serif; font-weight: 400;}';
      break;
    case 'Strait':
      $headings .= '"Strait",     sans-serif; font-weight: 400;}';
      break;
  }

  echo '<style type="text/css">';
  echo $body;
  echo $headings;
  echo 'a {color:' . $link . ';}';
  echo 'a:hover, a:focus {color:' . $link_hover . ';}';
  echo 'blockquote {border-left-color: ' . $blockquote . ';}';
  echo '.canvas { background-color: ' . $canvas . '; border-color: ' . $canvas_dark . '; color: ' . $canvas_text . '; }';
  echo '.navbar-inverse .navbar-nav > li > a, .canvas a, .canvas-light a { color: ' . $canvas_link . '; }';
  echo '.canvas a:hover, .canvas-light a:hover { color: ' . $canvas_text . '; }';
  echo '.site-branding a, .site-branding a:hover { color: ' . $canvas_text . '; }';
  echo '.navbar-inverse .navbar-nav > .dropdown > a .caret { border-top-color: ' . $canvas_link . '; border-bottom-color: ' . $canvas_link . '; }';
  echo '.navbar-inverse .navbar-nav > .open > a, .navbar-inverse .navbar-nav > .open > a:hover, .navbar-inverse .navbar-nav > .open > a:focus, .navbar-inverse .navbar-nav > li > a:hover, .navbar-inverse .navbar-nav > .active > a, .navbar-inverse .navbar-nav > .active > a:hover, .navbar-inverse .navbar-nav > .active > a:focus { color: ' . $canvas_text . '; background-color: ' . $canvas_dark . ';
}';
  echo '.canvas-light { background: ' . $canvas_light . '; color: ' . $canvas_text . '; }';
  echo '</style>';
}

/**
 * Returns slug or class for #primary based on theme options
 */
function flint_get_template( $output = 'slug', $template = '' ) {
  $options = get_option( 'flint_templates' );
  $file    = get_post_meta( get_the_ID(), '_wp_page_template', true );
  
  $default_width = !empty($options['default_width']) ? $options['default_width'] : 'full';
  $clear_width   = !empty($options['clear_width'])   ? $options['clear_width']   : 'full';
  $minimal_width = !empty($options['minimal_width']) ? $options['minimal_width'] : 'full';
  
  if (!empty($template)) { trigger_error('$template variable in flint_get_template() is deprecated as of Flint 1.2.1. Use get_template() to get a particular file.'); unset($t); }
  
  if (empty($file) | $file == 'default') {
    if ( is_active_sidebar('left') || is_active_sidebar('right') ) { $slug = 'wide'; }
    else { $slug = $default_width; }
  }
  elseif ($file == 'templates/clear.php') { $slug = $clear_width; }
  elseif ($file == 'templates/minimal.php') {
    if ( flint_is_active_widgets('left') || flint_is_active_widgets('right') ) { $slug = 'wide'; }
    else{ $slug = $minimal_width; }
  }
  
  switch ($output) {
    case 'slug':
      return $slug;
      break;
    case 'content':
      switch ($slug) {
        case 'full':
          echo 'col-lg-8 col-md-8 col-sm-8';
          break;
        case 'slim':
          echo 'col-lg-4 col-md-4 col-sm-4';
          break;
        case 'narrow':
          echo 'col-lg-6 col-md-6 col-sm-6';
          break;
        case 'wide':
          echo 'col-lg-12 col-md-12 col-sm-12';
          break;
      }
      break;
    case 'margins':
      switch ($slug) {
        case 'full':
          echo '<div class="col-lg-2 col-md-2 col-sm-2"></div>';
          break;
        case 'slim':
          echo '<div class="col-lg-4 col-md-4 col-sm-4"></div>';
          break;
        case 'narrow':
          echo '<div class="col-lg-3 col-md-3 col-sm-3"></div>';
          break;
        case 'wide':
          break;
      }
      break;
  }
  
}

/**
 * Returns slug or class for .widgets.widgets-footer based on theme options
 */
function flint_get_widgets_template( $output, $widget_area = 'footer' ) {
  $options = get_option( 'flint_templates' );
  $type    = get_post_type( get_the_ID() );
  
  $widgets_footer_width = !empty($options['widgets_footer_width']) ? $options['widgets_footer_width'] : 'match';
  
  switch ($widget_area) {
    case 'footer':
      if ($widgets_footer_width == 'match') {
        if ($type == 'page') { flint_get_template( $output ); }
        else { flint_get_template( $output, 'templates/full.php' ); }
      }
      else { flint_get_template( $output, 'templates/' . $widgets_footer_width . '.php'); }
      break;
  }
}

/**
 * Body class is determined by page template
 */
function flint_body_class() {
  global $post;
  $options = get_option( 'flint_templates' );
  if (!empty($post->ID)) {
    $template = get_post_meta( $post->ID, '_wp_page_template', true );
    $clear_nav   = !empty($options['clear_nav'])   ? $options['clear_nav']   : 'breadcrumbs';
    $minimal_nav = !empty($options['minimal_nav']) ? $options['minimal_nav'] : 'navbar';
    
    if ($template == 'templates/clear.php') {
      switch ($clear_nav) {
        case 'navbar':
          body_class('clear clear-nav');
          break;
        case 'breadcrumbs':
          body_class('clear clear-breadcrumbs');
          break;
      }
    }
    elseif ($template == 'templates/minimal.php') {
      switch ($minimal_nav) {
        case 'navbar':
          body_class('clear clear-nav');
          break;
        case 'breadcrumbs':
          body_class('clear clear-breadcrumbs');
          break;
      }
    }
    else { body_class(); }
  }
  else { body_class(); }
}

/**
 * Gets the featured image for a post or page if not specified otherwise in theme options
 */
function flint_post_thumbnail( $type = 'post', $loc = 'single') {
  $layout = get_option( 'flint_layout' );
  $posts_image = !empty($layout['posts_image']) ? $layout['posts_image'] : 'always';
  $pages_image = !empty($layout['pages_image']) ? $layout['pages_image'] : 'always';
  switch ($type) {
    case 'post':
      if ($posts_image == 'always') {if (has_post_thumbnail()) { the_post_thumbnail(); }}
      elseif ($posts_image == 'archives' && $loc == 'archive') {if (has_post_thumbnail()) { the_post_thumbnail(); }}
      break;
    case 'page':
      if ($pages_image == 'always') {if (has_post_thumbnail()) { the_post_thumbnail(); }}
      elseif ($pages_image == 'archives' && $loc == 'archive') {if (has_post_thumbnail()) { the_post_thumbnail(); }}
      break;
  }
}

/**
 * Similar to WordPress has_category()
 * Ignores "Uncategorized"
 */
function flint_has_category( $category = '', $post = null ) {
  if (has_term( $category, 'category', $post )) {
    $cats = '';
    foreach(get_the_category() as $cat) {
      if ($cat->cat_name != 'Uncategorized') {
        $cats .= $cat->cat_name;
      }
    }
    $output = trim($cats, ' ');
    if (!empty($output)) { return true; }
    else { return false; }
  }
  else {
    return false;
  }
}
