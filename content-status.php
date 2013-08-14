<?php
/**
 * @package Flint
 */
?>

  <div class="row">
    <div class="col-lg-2 col-md-2 col-sm-2">
      <?php if (has_post_thumbnail()) { the_post_thumbnail(); } ?>
    </div>
    <article id="post-<?php the_ID(); ?>" <?php post_class('col-lg-8 col-md-8 col-sm-8'); ?>>      
      <div class="entry-content">
        <h4><?php flint_the_content(); ?></h4>
      </div><!-- .entry-content -->
      
      <footer class="entry-meta clearfix">
        <?php flint_posted_on(); ?>
        <span class="sep"> | </span>
        <?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
          <span class="cat-links">
            Posted in
            <?php if ( flint_categorized_blog() ) {
              $categories = get_the_category();
              $separator = ' ';
              $output = '';
              if($categories){
                foreach($categories as $category) { $output .= '<a class="label label-default" href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( 'View all posts in %s', 'flint' ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;}
                echo trim($output, $separator);
              }
            } //if ( flint_categorized_blog() ) ?>
          </span><!-- .cat-links -->
          
          <span class="sep"> | </span>
          <span class="tags-links">
            Tagged
            <?php
            $tags = get_the_tags();
            $separator = ' ';
            $output = '';
            if($tags){
              foreach($tags as $tag) {$output .= '<a class="label label-info" href="'.get_tag_link( $tag->term_id ).'" title="' . esc_attr( sprintf( __( 'View all posts in %s', 'flint' ), $tag->name ) ) . '">'.$tag->name.'</a>'.$separator; }
              echo trim($output, $separator);
            } ?>
          </span><!-- .tags-links -->
        <?php endif; // End if 'post' == get_post_type() ?>
        
        <?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
          <span class="sep"> | </span>
          <span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'flint' ), __( '1 Comment', 'flint' ), __( '% Comments', 'flint' ) ); ?></span>
        <?php endif; ?>
      </footer><!-- .entry-meta -->
    </article><!-- #post-<?php the_ID(); ?> -->
    <div class="col-lg-1 col-md-1 col-sm-1"></div>
    <?php if ( current_user_can('edit_posts') ) { ?><a class="btn btn-default btn-sm col-lg-1 col-md-1 col-sm-1" href="<?php echo get_edit_post_link(); ?>">Edit</a><?php } ?>
  </div><!-- .row -->
