<?php
/**
 * The widget area that appears to the left of content.
 *
 * @package Flint
 * @since 1.2.0
 */
$type = get_post_type();
?>
<?php if ( is_active_sidebar( 'left' ) | is_active_sidebar( 'right' ) ) { ?>
  <div class="row">
  <?php if ( is_active_sidebar( 'left' ) ) { ?>
    <div class="col-lg-3 col-md-3 widgets widgets-left" role="complementary">
        <div class="widget-area" >
          <?php do_action( 'before_sidebar' ); ?>
          <?php do_action( 'flint_widget_area_left_'.$type ); ?>
          <?php dynamic_sidebar('left'); ?>
        </div><!-- .widget-area -->
    </div><!-- .widgets.widgets-left -->
  <?php } ?>
<?php } ?>