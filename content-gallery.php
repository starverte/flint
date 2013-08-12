<?php
/**
 * The template used for displaying galleries
 *
 * @package Flint
 */
?>

  <div class="row">
    <div class="col-lg-2 col-sm-2">
      <?php if (has_post_thumbnail()) { the_post_thumbnail(); } ?>
      <a class="btn btn-info btn-block" href="<?php echo get_permalink(); ?>">View gallery</a>
    </div>
    <article id="post-<?php the_ID(); ?>" <?php post_class('col-lg-8 col-sm-8'); ?>>
      <header class="entry-header">
        <h1 class="entry-title"><?php if (is_single()) { echo the_title(); } else { $permalink = get_permalink(); $title = get_the_title(); echo '<a href="' . $permalink .'" rel="bookmark">' . $title . '</a>'; } ?></h1>
      </header><!-- .entry-header -->
      
      <?php if ( is_search() ) : // Only display Excerpts for Search ?>
      <div class="entry-summary">
        <?php the_excerpt(); ?>
      </div><!-- .entry-summary -->
      <?php else : ?>
      <div class="entry-content">
        <?php if (is_single()) { flint_the_content(); }
        else {
          $pattern = get_shortcode_regex();
          preg_match( "/$pattern/s", get_the_content(), $match );
          $atts   = isset( $match[3] ) ? shortcode_parse_atts( $match[3] ) : array();
          $images = isset( $atts['ids'] ) ? explode( ',', $atts['ids'] ) : false;
          
          if ( ! $images ) {
            $images = get_posts( array(
            'post_parent'      => get_the_ID(),
            'fields'           => 'ids',
            'post_type'        => 'attachment',
            'post_mime_type'   => 'image',
            'orderby'          => 'menu_order',
            'order'            => 'ASC',
            'numberposts'      => 999,
            'suppress_filters' => false
            ) );
          }  
          
          if ( $images ) {
            $total_images = count( $images );
            $image        = array_shift( $images ); ?>
            
            <p><a class="gallery-thumb" href="<?php the_permalink(); ?>"><?php echo wp_get_attachment_image( $image, 'large' ); ?></a></p>
            
            <p class="gallery-info">
              <?php
              printf( _n( 'This gallery contains <a %1$s>%2$s photo</a>.', 'This gallery contains <a %1$s>%2$s photos</a>.', $total_images, 'flint' ),
              'href="' . get_permalink() . '" title="' . esc_attr( sprintf( __( 'Permalink to %s', 'flint' ), the_title_attribute( 'echo=0' ) ) ) . '" rel="bookmark"',
              number_format_i18n( $total_images )
              ); ?>
            </p>
            
            <?php the_excerpt(); ?>
            
          <?php } // if ( $images )
        } //not single ?>
        <?php
        flint_link_pages( array(
          'before' => '<ul class="pagination">',
          'after'  => '</ul>',
        ) );
        ?>
      </div><!-- .entry-content -->
      <?php endif; ?>
      
    </article><!-- #page-<?php the_ID(); ?> -->
    <div class="col-lg-1 col-sm-1"></div>
    <?php if ( current_user_can('edit_posts') ) { ?><a class="btn btn-default btn-small col-lg-1 col-sm-1" href="<?php echo get_edit_post_link(); ?>">Edit</a><?php } ?>
  </div><!-- .row -->
