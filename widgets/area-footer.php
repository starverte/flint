<?php
/**
 * The widget area that appears below the content.
 *
 * @package Flint
 * @since 1.2.0
 */
$type = get_post_type();
?>
<?php if ( is_active_sidebar( 'footer' ) ) { ?>
  <div class="canvas-light widgets widgets-footer" role="complementary">
    <div class="container">
      <?php flint_get_widgets_template('margins', 'footer'); ?>
      <div class="widget-area <?php flint_get_widgets_template('content', 'footer'); ?>" >
        <?php do_action( 'before_sidebar' ); ?>
        <?php do_action( 'flint_widget_area_footer_'.$type ); ?>
        <?php dynamic_sidebar('footer'); ?>
      </div><!-- .widget-area -->
      <?php flint_get_widgets_template('margins', 'footer'); ?>
    </div>
  </div><!-- .widgets.widgets-footer -->
<?php } ?>
