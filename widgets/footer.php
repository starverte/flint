<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Flint
 */
?>
  <div class="canvas-light widgets widgets-footer" role="complementary">
    <div class="container">
      <?php flint_get_widgets_template('margins', 'footer'); ?>
      <div class="widget-area <?php flint_get_widgets_template('content', 'footer'); ?>" >
        <?php do_action( 'before_sidebar' ); ?>
        <?php if ( ! dynamic_sidebar( 'footer' ) ) : ?>
        <?php endif; ?>
      </div><!-- .widget-area -->
      <?php flint_get_widgets_template('margins', 'footer'); ?>
    </div>
  </div><!-- .widgets.widgets-footer -->
