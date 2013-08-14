<?php
/**
 * @package Flint
 */
?>

  <div class="col-lg-2 col-md-2 col-sm-2">
    <?php if (has_post_thumbnail()) { the_post_thumbnail(); } ?>
    <?php if (has_download_btn()) { the_download_btn(); } ?>
  </div>
  <article id="post-<?php the_ID(); ?>" <?php post_class('col-lg-1 col-lg-10 col-md-10 col-sm-10 col-xs-10'); ?>>
    <header class="entry-header">
      <h1 class="entry-title"><?php the_title(); ?></h1>
  
      <div class="entry-meta">
        <?php flint_posted_on(); ?>
      </div><!-- .entry-meta -->
    </header><!-- .entry-header -->
  
    <div class="entry-content">
      <?php the_content(); ?>
      <?php
        flint_link_pages( array(
          'before' => '<ul class="pagination">',
          'after'  => '</ul>',
        ) );
      ?>
    </div><!-- .entry-content -->
  
    <footer class="entry-meta clearfix">
      <?php
        /* translators: used between list items, there is a space after the comma */
        $category_list = get_the_category_list( __( ', ', 'flint' ) );
  
        /* translators: used between list items, there is a space after the comma */
        $tag_list = get_the_tag_list( '', __( ', ', 'flint' ) );
  
        if ( ! flint_categorized_blog() ) {
          // This blog only has 1 category so we just need to worry about tags in the meta text
          if ( '' != $tag_list ) {
            $meta_text = __( 'This entry was tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'flint' );
          } else {
            $meta_text = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'flint' );
          }
  
        } else {
          // But this blog has loads of categories so we should probably display them here
          if ( '' != $tag_list ) {
            $meta_text = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'flint' );
          } else {
            $meta_text = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'flint' );
          }
  
        } // end check for categories on this blog
  
        printf(
          $meta_text,
          $category_list,
          $tag_list,
          get_permalink(),
          the_title_attribute( 'echo=0' )
        );
      ?>
  
    </footer><!-- .entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->
